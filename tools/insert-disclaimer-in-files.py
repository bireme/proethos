#!/usr/bin/env python
#!coding:utf-8

import os
import sys
import time

available_extensions = ['.py', '.php', '.css', '.js']
# available_extensions = ['.py', '.php', ]

paths_exception = ['/libs/email/']

disclaimer_content = """This file is part of the ProEthos Software. 

Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
ProEthos under the terms of the ProEthos License as published by PAHO, which
restricts commercial use of the Software. 

ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the ProEthos License for more details. 

You should have received a copy of the ProEthos License along with the ProEthos
Software. If not, see
https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt"""

try:
	rootpath = sys.argv[1]
except IndexError:
	print 'ERRO: Preencha com o parâmetro do path do projeto.'
	sys.exit(1)


exists = 0
total = 0
error = 0
for root, dirs, files in os.walk(rootpath):
	for file in files:

		file = os.path.join(root, file)

		is_exception = False
		for path in paths_exception:
			if path in unicode(file):
				is_exception = True
				break

		if is_exception:
			continue
		
		is_allowed = False
		extension = None
		for ext in available_extensions:
			if file.endswith(ext):
				is_allowed = True
				extension = ext
				break

		if not is_allowed:
			continue

		total += 1
			
		with open(file) as handle:
			content = handle.read().strip()

		if disclaimer_content.split("\n")[0].strip() in content:
			exists += 1
			continue

		# if extension is '.php':
		# 	if content.strip():
		# 		if not content.strip().startswith("<?"):
		# 			os.system("subl %s" % file)
		# 			print("subl %s" % file)
		# continue

		# limpa a tela
		os.system("clear")

		print '==============================================================================='
		print 'file: %-57s extension: %-s' % (file, extension)
		print '==============================================================================='
		# print 'ORIGINAL:'
		# print '-------------------------------------------------------------------------------'

		# for i in range(3):
		# 	print content.split("\n")[i].strip()

		# trata da extensão php
		if extension is '.php':

			# adiciona como comentário
			newdisclaimer = ""
			for line in disclaimer_content.split("\n"):
				newdisclaimer += "// %s\n" % line

			# troca
			changed = False
			line = content.strip().split("\n")[0]

			tag = "<?php"
			if not tag in line:
				tag = "<?"

			if tag in line:
		
				# faz o replace da tag
				newline = line.replace(tag, "%s\n%s\n" % (tag, newdisclaimer))

				# faz o replace no content
				content = content.replace(line, newline)
				changed = True

			if not changed:
				content = "<?php\n%s\n?>\n\n%s" % (newdisclaimer, content)
		

		if extension is '.css':

			newdisclaimer = "/*\n%s\n*/\n" % disclaimer_content
			content = "%s\n\n%s" % (newdisclaimer, content)

		if len(content.split("\n")) > 25:
			for i in range(25):
				print content.split("\n")[i].strip()
		else:
			for i in range(len(content.split("\n"))):
				print content.split("\n")[i].strip()


		# raw_input()
		time.sleep(1)

		# try:
		# 	with open(file, 'w') as output:
		# 		output.write(content)
		# except IOError:
		# 	pass

os.system("clear")
print "Total: %s" % total
print "Exists: %s" % exists
print "Error: %s" % error