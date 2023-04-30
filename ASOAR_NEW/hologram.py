import cv2
import numpy as np
import matplotlib.pyplot as plt
import json
from PIL import Image

with open('/var/www/html/ASOAR_NEW/getFunction.json') as f:
    df = json.load(f)
#print(df['img_name']) jsonの中に何が格納されているか表示される

image_path = df['img_name']

#画像読み込み
black = Image.open("/var/www/html/ASOAR_NEW/black.jpg")
top = Image.open('/var/www/html/ASOAR_NEW/scripts/examples/skepng/' + image_path)

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

path = '/var/www/html/ASOAR_NEW/scripts/examples/hologram/' + image_path

#サーバー上にアップロードする
black.save(path)