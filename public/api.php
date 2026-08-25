<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
$storage = dirname(__DIR__) . '/storage';
if (!is_dir($storage)) mkdir($storage, 0775, true);
$pdo = new PDO('sqlite:' . $storage . '/qlts.sqlite', null, null, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
$pdo->exec(file_get_contents(dirname(__DIR__) . '/database/schema.sql'));
$auditColumns=array_column($pdo->query('PRAGMA table_info(audit_logs)')->fetchAll(),'name');
if(!in_array('username',$auditColumns,true)) $pdo->exec('ALTER TABLE audit_logs ADD COLUMN username TEXT');
if(!in_array('actor_name',$auditColumns,true)) $pdo->exec('ALTER TABLE audit_logs ADD COLUMN actor_name TEXT');
if(!in_array('previous_hash',$auditColumns,true)) $pdo->exec('ALTER TABLE audit_logs ADD COLUMN previous_hash TEXT');
if(!in_array('entry_hash',$auditColumns,true)) $pdo->exec('ALTER TABLE audit_logs ADD COLUMN entry_hash TEXT');
$method=$_SERVER['REQUEST_METHOD']; $resource=$_GET['resource']??'assets';
try {
 if($resource==='audit'){
   if($method==='GET'){
     $s=$pdo->query('SELECT id, created_at AS time, username, actor_name, action, object_type AS objectType, object_id AS objectId, detail, ip_address AS ipAddress FROM audit_logs ORDER BY id DESC LIMIT 500');
     $rows=array_map(static function(array $row):array{$row['user']=($row['actor_name']?:'Không xác định').' ('.($row['username']?:'unknown').')';return $row;},$s->fetchAll());
     echo json_encode(['data'=>$rows,'immutable'=>true,'policy'=>'append-only'],JSON_UNESCAPED_UNICODE);exit;
   }
   if($method==='POST'){
     $input=json_decode(file_get_contents('php://input'),true)??[];
     foreach(['username','actorName','action','objectType','detail'] as $k) if(trim((string)($input[$k]??''))==='') throw new InvalidArgumentException("Thiếu trường $k");
     $previous=(string)($pdo->query('SELECT entry_hash FROM audit_logs ORDER BY id DESC LIMIT 1')->fetchColumn()?:'GENESIS');
     $created=(new DateTimeImmutable('now',new DateTimeZone('Asia/Bangkok')))->format('Y-m-d H:i:s');
     $fingerprint=json_encode([$previous,$input['username'],$input['actorName'],$input['action'],$input['objectType'],$input['objectId']??null,$input['detail'],$created],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
     $entryHash=hash('sha256',$fingerprint);
     $s=$pdo->prepare('INSERT INTO audit_logs(username,actor_name,action,object_type,object_id,detail,ip_address,created_at,previous_hash,entry_hash) VALUES(?,?,?,?,?,?,?,?,?,?)');
     $s->execute([$input['username'],$input['actorName'],$input['action'],$input['objectType'],$input['objectId']??null,$input['detail'],$_SERVER['REMOTE_ADDR']??null,$created,$previous,$entryHash]);
     http_response_code(201);echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);exit;
   }
   http_response_code(405);echo json_encode(['error'=>'Method not allowed']);exit;
 }
 if($resource!=='assets') throw new RuntimeException('Resource chưa được hỗ trợ');
 if($method==='GET'){
   $q=trim($_GET['q']??''); $sql='SELECT * FROM assets'; $args=[];
   if($q!==''){$sql.=' WHERE asset_code LIKE :q OR name LIKE :q';$args[':q']='%'.$q.'%';}
   $sql.=' ORDER BY created_at DESC';$s=$pdo->prepare($sql);$s->execute($args);echo json_encode(['data'=>$s->fetchAll()],JSON_UNESCAPED_UNICODE);exit;
 }
 $input=json_decode(file_get_contents('php://input'),true)??[];
 if($method==='POST'){
   foreach(['asset_code','name','category','department','location'] as $k) if(empty($input[$k])) throw new InvalidArgumentException("Thiếu trường $k");
   $s=$pdo->prepare('INSERT INTO assets(asset_code,name,category,model_serial,purchase_date,department,location,status,price,useful_life) VALUES(?,?,?,?,?,?,?,?,?,?)');
   $s->execute([$input['asset_code'],$input['name'],$input['category'],$input['model_serial']??'', $input['purchase_date']??null,$input['department'],$input['location'],$input['status']??'Đang sử dụng',(float)($input['price']??0),(int)($input['useful_life']??5)]);
   http_response_code(201);echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);exit;
 }
 if($method==='DELETE'){
   $id=(int)($_GET['id']??0);$s=$pdo->prepare('DELETE FROM assets WHERE id=?');$s->execute([$id]);echo json_encode(['ok'=>true]);exit;
 }
 http_response_code(405);echo json_encode(['error'=>'Method not allowed']);
}catch(Throwable $e){http_response_code($e instanceof InvalidArgumentException?422:400);echo json_encode(['error'=>$e->getMessage()],JSON_UNESCAPED_UNICODE);}
