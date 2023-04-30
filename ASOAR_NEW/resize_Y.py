# 画像ファイルのサイズを確認して、指定サイズより大きい場合は指定サイズまで削減する
# 引数：確認するファイルパス
# 戻り値：true : サイズ削減を実施 false: サイズ削減実施せず

import io,sys
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
import imghdr
from PIL import Image
import os
import json

with open('/var/www/html/ASOAR_NEW/getFunction.json') as f:
    df = json.load(f)
    
id = df['img_name']

def resize_img_file(file_path):
    is_resize = False

    # ファイルが画像ファイルかどうかを確認し、画像ファイルではない場合リサイズ処理は行わない
    img_type = imghdr.what(file_path)
    if img_type is None:
        return is_resize

    # ファイルサイズ確認
    if os.path.getsize(file_path) >= MAX_FILE_SIZE:
        is_resize = True

        img = Image.open(file_path)
        width = MAX_WIDTH
        height = img.height * (MAX_WIDTH / img.width)
        resize = img.resize((int(width), int(height)))
        resize.save(file_path)

        # 画質のデフォルトは75
        quality = MAX_QUALITY

        while True:
            if int(os.path.getsize(file_path)) < MAX_FILE_SIZE:
                break
            img = Image.open(file_path)
            img.save(file_path, quality=quality, optimize=False)
            if quality >= 5:
                quality -= 10
            else:
                break

    return is_resize


# 指定フォルダ配下にある画像ファイルを処理
def recursive_resize_img_file(file_path):
    if os.path.isdir(file_path):
        files = os.listdir(file_path)
        for file in files:
            recursive_resize_img_file(os.path.join(file_path, file))
    else:
        resize_img_file(file_path)


MAX_FILE_SIZE = 100000
MAX_WIDTH = 400
MAX_QUALITY = 75
url = './scripts/examples/images/'+id
recursive_resize_img_file(url)

#変更しちゃダメ!!