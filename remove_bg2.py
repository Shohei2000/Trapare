#!/usr/bin/python
# -*- coding: utf-8 -*-
import json
import cv2
import os
from PIL import Image
#import pymysql.cursors

import qrcode

with open('/var/www/html/getFunction.json') as f:
    df = json.load(f)
    
id = df['img_name']
#count = df['count']

#img = cv2.imread('./scripts/examples/images/'+id, -1)
#img = img[...,::-1]
#matte = cv2.imread('./scripts/examples/mattes/'+id)

im_rgb = Image.open('./scripts/examples/images/'+id)
im_a = Image.open('./scripts/examples/mattes/'+id)

im_rgb.putalpha(im_a)

#変更点

#try:
#    im_rgb.save('./scripts/examples/'+id)
#    lolipopURL = 'http://ssh-1.mc.lolipop.jp/var/www/html/scripts/examples/'+id
#    im_rgb.save('http://ssh-1.mc.lolipop.jp/var/www/html/scripts/examples/'+id)
#    im_rgb.save('http://44.193.40.126/scripts/examples/'+id)
#except Exception as e:
#    print(e)
#↓
#ARカメラを起動するのは、Lolipopのサーバーなので透過pngをLolipopのサーバーにも保存しないといけない！

im_rgb.save('./scripts/examples/'+id)
file_name="./scripts/examples/qr/"+df['img_name']

#パラメータ付与
name = "https://44.194.34.105//ar.php?name="+id
img = qrcode.make(name)  # QRコード画像データ生成

img.save(file_name)  # 画像ファイルとして保存
current_dir = os.getcwd()  # 現在のディレクトリ位置を取得

# connection = pymysql.connect(host='localhost',
#                              user='arhologram',
#                              password='arhologram',
#                              db='images',
#                              charset='utf8',
#                              # cursorclassを指定することで
#                              # Select結果をtupleではなくdictionaryで受け取れる
#                              cursorclass=pymysql.cursors.DictCursor)

# with connection.cursor() as cursor:
#     sql = "INSERT INTO images (ID, IMAGE) VALUES (%s, %s)"
#     r = cursor.execute(sql, (count, file_name))
#     print(r) # -> 1
#     # autocommitではないので、明示的にコミットする
#     connection.commit()