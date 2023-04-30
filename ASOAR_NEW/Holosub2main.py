#!/usr/bin/python
# -*- coding: utf-8 -*-
import cv2
import numpy as np
import json
from PIL import Image
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt

import qrcode

with open('/var/www/html/ASOAR_NEW/getFunction2.json') as f:
    df = json.load(f)
# print(df['img_name']) jsonの中に何が格納されているか表示される

r= df['r']
g= df['g']
b= df['b']
a= df['a']
img_name = df['img_name']
flag = df['transparent']

url1 = './scripts/examples/images/'+img_name
url2 = './scripts/examples/trimaps/'+img_name
url3 = './scripts/examples/mattes/'+img_name
url4 = './scripts/examples/skepng/'+img_name

#デバッグ用
#print(url1)
#print(url2)
#print(url3)
#print(url4)

r_up = int(r) + 10
g_up = int(g) + 10
b_up = int(b) + 10

r_low = int(r) - 10
g_low = int(g) - 10
b_low = int(b) - 10

img = cv2.imread(url1, -1)   # -1はAlphaを含んだ形式(0:グレー, 1:カラー)

color_upper = np.array([float(b), float(g), float(r), float(a)])# 抽出する色の上限(BGR形式)
color_lower = np.array([float(b_low), float(g_low), float(r_low), float(a)])                 # 抽出する色の下限(BGR形式)

img_mask = cv2.inRange(img, color_lower, color_upper)    # 範囲からマスク画像を作成

cv2.imwrite(url2, img_mask)                         # 画像保存
img_bool = cv2.bitwise_not(img_mask)

cv2.imwrite(url3, img_bool)                         # 画像保存

im_rgb = Image.open(url1)
im_a = Image.open(url3)

im_rgb.putalpha(im_a)

im_rgb.save(url4)

black = Image.open("/var/www/html/ASOAR_NEW/black.jpg")
top = Image.open('/var/www/html/ASOAR_NEW/scripts/examples/skepng/' + img_name)

print('OK')

#サイズ調整
def scale_to_width(img, width):
    height = round(img.height * width / img.width)
    if height > 237:
        width = round(width * 237 / height)
        height = 237
    return img.resize((width, height))

#関数実行
top = scale_to_width(top, 276)

#左用、右用、下用の画像を変数として代入
bottom = top
bottom = bottom.rotate(180 ,expand=True)
bottom = bottom.resize((top.width, top.height))
left = top
left = left.rotate(90 ,expand=True)
left = left.resize((top.height, top.width))
right = top
right = right.rotate(270 ,expand=True)
right = right.resize((top.height, top.width))

#黒色の画像のどこに配置するのか指定するための数値を変数に代入
im_height = top.height
top_width = int(600 - top.width /2)
left_width = top_width - im_height
right_width = left_width + im_height + top.width
bottom_height = 75 + top.height + top.width

#背景となる黒い画像のサイズを決定
black = black.resize((1200,900))

#背景にそれぞれ上、左、下、右に画像を展開する
black.paste(top, (top_width, 75))
black.paste(left, (left_width, im_height + 75))
black.paste(right, (right_width, im_height + 75))
black.paste(bottom, (top_width, bottom_height))

path = '/var/www/html/ASOAR_NEW/scripts/examples/hologram/' + img_name

#サーバー上にアップロードする
black.save(path)


