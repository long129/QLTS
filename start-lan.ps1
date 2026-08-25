param(
    [int]$Port = 8080
)

$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$PublicRoot = Join-Path $ProjectRoot 'public'
$PhpExecutable = 'C:\Tools\php84\php.exe'

if (-not (Test-Path -LiteralPath $PhpExecutable)) {
    Write-Error "Không tìm thấy PHP tại $PhpExecutable"
    exit 1
}

if (-not (Test-Path -LiteralPath $PublicRoot)) {
    Write-Error "Không tìm thấy web root tại $PublicRoot"
    exit 1
}

$LanAddress = (ipconfig | Select-String 'IPv4 Address.*: (192\.168\.1\.\d+)' | ForEach-Object { $_.Matches[0].Groups[1].Value } | Select-Object -First 1)
Write-Host "QLTS Enterprise đang khởi động..." -ForegroundColor Cyan
Write-Host "Trên máy chủ : http://localhost:$Port" -ForegroundColor Green
if ($LanAddress) {
    Write-Host "Trong mạng LAN: http://${LanAddress}:$Port" -ForegroundColor Green
}
Write-Host "Nhấn Ctrl+C để dừng." -ForegroundColor Yellow

& $PhpExecutable -S "0.0.0.0:$Port" -t $PublicRoot
