from flask import Flask, render_template, request, redirect, url_for, session
from flask_mysqldb import MySQL
import MySQLdb.cursors
import re
from sentence_transformers import SentenceTransformer, util
import numpy as np
import hashlib
from transformers import AutoTokenizer, AutoModel
import torch
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)
#tokenizer = AutoTokenizer.from_pretrained('sentence-transformers/bert-base-nli-mean-tokens')
#model= SentenceTransformer('stsb-roberta-large')
model = SentenceTransformer('bert-base-nli-mean-tokens')

app.secret_key = '7510'

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'acelogic'

mysql = MySQL(app)


@app.route('/')
@app.route('/login', methods=['GET', 'POST'])
def login():
    msg = ''
    if request.method == 'POST' and 'uname' in request.form and 'pwd' in request.form:
        username = request.form['uname']
        print(username)
        password = request.form['pwd']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT * FROM tbl_registered_user_list WHERE uname = % s AND password = % s and exam_cell = 1', (username, password,))
        account = cursor.fetchone()
        if account:
            session['loggedin'] = True
            #session['EC_id'] = account['EC_id']
            session['username'] = account['uname']
            msg = 'Logged in successfully !'
            return render_template('dashboard.html')
        else:
            msg = 'Incorrect username / password !'
    return render_template('staff_login.html', msg=msg)

if __name__ == '__main__':
    app.run()
