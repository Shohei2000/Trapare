#!/usr/bin/python
# -*- coding: utf-8 -*-
import torch
import torchvision
from torchvision import transforms
import ssl
ssl._create_default_https_context = ssl._create_unverified_context

try:
    model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True)
    print('ok')
except Exception as e:
    print(e.args)