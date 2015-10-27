#!coding: utf-8
import json
import sys
import os

FILE = sys.argv[1]

count = 0
with open(FILE) as handle:
	for line in handle:
		
		try:
			print line.strip().decode('cp1252')
		except:
			print line.strip()
			pass
