#!/usr/bin/env python
#coding=utf-8

"""############################################################

//使用方法：把需要导入的员工数据拷贝到当前目录，重命名为employees
//		配置database
//执行 python import.py
//使用条件：employees文件的记录严格满足column定义的格式
//
//默认username为名字全拼,重名加数字后缀
//默认pwd为1q2w3e4r, md5
//默认mobile为11111111111
//默认role为普通员工, 8
//默认mail为username@zhlbt.com
//position和department进行关联

############################################################"""



import MySQLdb
import md5
from pinyin import PinYin

# init hanzi2pinyin tool
h2p = PinYin()
h2p.load_word()

# global varialbes
employee_file = "employees"
md5_prefix = 'psd_'
default_pwd = '1q2w3e4r'
default_mobile = '11111111111'
mobile = '11111111111'
role = 8
m = md5.new(md5_prefix + default_pwd)
m.digest()
pwd = m.hexdigest()

# config database
db_host='localhost'
db_user='root'
db_passwd='rootme'
db_name='crm'

column = ('id', 'name', 'no', 'department', 'position')
#dept = {'总经理部','财务部','采购部','人事行政部', '设计部', '施工部', '市场合同部', '项目运营部'}
userNames = {}
departmentTypes = {}
positionTypes = {}
nos= {}

#建立和数据库系统的连接
conn = MySQLdb.connect(host=db_host, user=db_user, passwd=db_passwd, charset='utf8')
#选择数据库
conn.select_db(db_name);

#获取操作游标
cursor = conn.cursor()
cursor.execute("SET NAMES utf8")
cursor.execute("SET CHARACTER_SET_CLIENT=utf8")
cursor.execute("SET CHARACTER_SET_RESULTS=utf8")
conn.commit()

#获取当前数据库的nos, userNames,departmentTypes, positionTypes
count = cursor.execute('select id,no,username from Employee')
results = cursor.fetchall()
for r in results:
	nid = r[0]
	no = r[1]
	username = r[2]
	userNames[username] = nid
	nos[no] = nid

count = cursor.execute('select id,name from DeptType')
results = cursor.fetchall()
for r in results:
	nid = r[0]
	name = r[1]
	departmentTypes[name] = nid
	
count = cursor.execute('select id,name from PositionType')
results = cursor.fetchall()
for r in results:
	nid = r[0]
	name = r[1]
	positionTypes[name] = nid

# parse file and import data to db
fd = open(employee_file, 'r')
for line in fd.readlines():
	value = {}
	line = line.strip()
	items = line.split('\t')

	name = items[1]
	no = items[2]

	if no in nos.keys():
		continue

	username = h2p.hanzi2pinyin_split(string=name, split='')
	i = 0
	while username in userNames.keys():
		i = i + 1
		username = username + str(i)

	departmentName = items[3]
	if departmentName not in departmentTypes.keys():
		cursor.execute("insert into DeptType (name) values(%s)", (departmentName))
		cursor.execute("select id from DeptType where name=%s", (departmentName))
		id = cursor.fetchone()[0]
		departmentTypes[departmentName] = id
	department = departmentTypes[departmentName]

	positionName = items[4]
	if positionName not in positionTypes.keys():
		cursor.execute("select id from DeptType where name=%s", (departmentName))
		deptId = cursor.fetchone()[0]
		cursor.execute("insert into PositionType (name,department) values(%s, %s)", (positionName,deptId))
		cursor.execute("select id from PositionType where name=%s", (positionName))
		id = cursor.fetchone()[0]
		positionTypes[positionName] = id
	position = positionTypes[positionName]

	mail = username + '@zhlbt.com'
	cursor.execute("insert into Employee (name,no,username,department,position,pwd,mobile,role,mail) values(%s,%s,%s,%s,%s,%s,%s,%s,%s)", (name,no,username,department,position,pwd,mobile,role,mail) )
	userNames[username] = 1
	nos[no] = 1

conn.commit()
#关闭连接，释放资源
cursor.close();

