#!/usr/bin/env python3
"""Kiểm tra CSV tài sản và chuyển thành JSON UTF-8 để import qua API."""
import csv, json, sys
from pathlib import Path
REQUIRED = {"asset_code", "name", "category", "department", "location"}
def main():
    if len(sys.argv) < 2:
        raise SystemExit("Dùng: python tools/import_assets.py danh_sach.csv [ket_qua.json]")
    source=Path(sys.argv[1]); target=Path(sys.argv[2]) if len(sys.argv)>2 else source.with_suffix('.json')
    with source.open(encoding='utf-8-sig', newline='') as f:
        rows=list(csv.DictReader(f)); missing=REQUIRED-set(f.fieldnames or [])
    if missing: raise SystemExit("Thiếu cột: " + ", ".join(sorted(missing)))
    errors=[]
    for i,row in enumerate(rows,2):
        for col in REQUIRED:
            if not row.get(col,'').strip(): errors.append(f"Dòng {i}: {col} đang trống")
        try: row['price']=float(row.get('price') or 0); row['useful_life']=int(row.get('useful_life') or 5)
        except ValueError: errors.append(f"Dòng {i}: price/useful_life không hợp lệ")
    if errors: raise SystemExit("\n".join(errors))
    target.write_text(json.dumps(rows,ensure_ascii=False,indent=2),encoding='utf-8')
    print(f"Đã tạo {target} với {len(rows)} tài sản")
if __name__=='__main__': main()
