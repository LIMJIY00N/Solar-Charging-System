#!/usr/bin/env python
# coding: utf-8

# In[96]:


import pandas as pd
import numpy as np
import os
import glob
import random
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import csv

from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split

from urllib.request import urlopen
from bs4 import BeautifulSoup
from datetime import datetime
from datetime import timedelta
# import schedule
import requests
import json
import time

import warnings

import requests
import json
import urllib.request
from pandas.io.json import json_normalize
warnings.filterwarnings("ignore")


# In[97]:


# mysql에서 데이터셋 가져오기
url = requests.get("http://solarcharging.dothome.co.kr/TrainDataApi.php?apicall=getinfo")
text = url.text
# json형식으로 변환
json_data = json.loads(text)
# error 코드 제외하고 가져오기
train = json_normalize(json_data['TrainData'])
# train.tail()

# 엑셀파일로 컴퓨터에 저장
# train.to_csv("samplecsv.csv") 


# In[ ]:





# In[98]:


# train = pd.read_csv('Solar_TrainData_3.csv')
train.tail()


# In[99]:


temp = train[['Iljo','T','Rain','Wind','H','Ilsa','Cloud']]
 

def preprocess_data(data,is_train): #데이터 전처리(결측치 처리하기)
    
    temp = data.copy()
    
    
    if is_train==True:          #train 데이터면
        temp = temp[['Ilsa','T','Rain','Wind','H','Iljo','Cloud']]
        #temp['Target1'] = temp['Target'].shift(-1).fillna(method='ffill') 
        temp = temp.dropna() #결측값(NaN) 있는 행 제거
        
        #return temp.iloc[:-2] 
        return temp

    elif is_train==False:
        
        temp = temp[['Ilsa','T','Rain','Wind','H','Iljo','Cloud']]

        #return temp.iloc[-1:,:]
        return temp

df_train = preprocess_data(train,1)
df_train.iloc[:48] #47번째 행까지가져옴(1일차)



lm = LinearRegression()
X_Data= df_train[['T','Rain','Wind','H','Iljo','Cloud']]

Y_Data= df_train['Ilsa']

model = lm.fit(pd.DataFrame(X_Data),y=Y_Data)
prediction = model.predict(X = pd.DataFrame(X_Data))
print('a value =',model.intercept_)
print('b value = ',model.coef_)
print("=============================")

    

print(prediction)

residuals = Y_Data-prediction
residuals.describe()
SSE = (residuals**2).sum()
SST =((Y_Data- Y_Data.mean())**2).sum()
R_squared = 1-(SSE/SST)
print("R_squared = ",R_squared)

from sklearn.metrics import mean_squared_error
print('score =',model.score(X=pd.DataFrame(X_Data),y=Y_Data))
print('Mean_Squared_Error =',mean_squared_error(prediction,Y_Data))
print('RMSE =',mean_squared_error(prediction,Y_Data)**0.5)

fig = plt.figure(figsize = (12,4))
graph = fig.add_subplot(1,1,1)
graph.plot(Y_Data[:50],marker = 'o',color = 'blue',label="실제값")
graph.plot(prediction[:50],marker = '^',color ='red',label = "예측값")
graph.set_title('다중회귀분석 예측 결과',size = 30)
plt.xlabel("횟수")
plt.ylabel("발전량")
plt.legend(loc='best')


# In[100]:


import statsmodels.api as sm
model = sm.OLS(Y_Data,X_Data).fit()
model.summary()


# In[ ]:





# In[101]:


#print(temp)
if "predict" not in train:
    train.insert(9,"predict",prediction)
else:
    train["predict"].replace(prediction)
#print(temp)

#temp.drop('predict',axis =1)
#print(train)
print(train)


# In[54]:





# In[55]:





# In[61]:





# In[102]:


print(train)


# In[103]:


def preprocess_data(data,is_train): #데이터 전처리(결측치 처리하기)
    
    temp = data.copy()
    
    
    if is_train==True:          #train 데이터면
        temp = temp[['Target','T','Rain','Wind','H','Iljo','Ilsa','Cloud','predict']]
        #temp['Target1'] = temp['Target'].shift(-1).fillna(method='ffill') 
        temp = temp.dropna() #결측값(NaN) 있는 행 제거
        
        #return temp.iloc[:-2] 
        return temp

    elif is_train==False:
        
        temp = temp[['T','Rain','Wind','H','Iljo','Ilsa','Cloud','predict']]

        #return temp.iloc[-1:,:]
        return temp

df_train_p = preprocess_data(train,1)



lm_p = LinearRegression()
X_Data_p= df_train_p[['T','Rain','Wind','H','Iljo','Cloud','predict']]
Y_Data_p= df_train_p['Target']

model_p = lm_p.fit(pd.DataFrame(X_Data_p),y=Y_Data_p)
prediction_p = model_p.predict(X = pd.DataFrame(X_Data_p))
print('a value =',model_p.intercept_)
print('b value = ',model_p.coef_)
print(prediction_p)
residuals_p = Y_Data_p-prediction_p
residuals_p.describe()
SSE_p = (residuals_p**2).sum()
SST_p =((Y_Data_p- Y_Data_p.mean())**2).sum()
R_squared_p = 1-(SSE_p/SST_p)
print("R_squared = ",R_squared_p)


from sklearn.metrics import mean_squared_error
print('score =',model_p.score(X=pd.DataFrame(X_Data_p),y=Y_Data_p))
print('Mean_Squared_Error =',mean_squared_error(prediction_p,Y_Data_p))
print('RMSE =',mean_squared_error(prediction_p,Y_Data_p)**0.5)

fig = plt.figure(figsize = (12,4))
graph = fig.add_subplot(1,1,1)
graph.plot(Y_Data_p[:50],marker = 'o',color = 'blue',label="실제값")
graph.plot(prediction_p[:50],marker = '^',color ='red',label = "예측값")
graph.set_title('다중회귀분석 예측 결과',size = 30)
plt.xlabel("횟수")
plt.ylabel("발전량")
plt.legend(loc='best')


# In[41]:





# In[110]:


#mysql에서 크롤링한 데이터 가져오기
#NowWeatherData = 
#x_result = NowWeatherData[['Day','T','Rain','Wind','H','Iljo','Ilsa','Cloud']] 

#y_result = mlr.predict(x_result)
# print(y_result)


url = "http://solarcharging.dothome.co.kr/NowWeatherApi.php?apicall=getinfo"
#response = requests.get(url)

req = urllib.request.urlopen(url)
res = req.readline()

j = json.loads(res)

solar = [[j["weather"][0]["T"],j["weather"][0]["Rain"],j["weather"][0]["Wind"],j["weather"][0]["H"]*0.01,j["weather"][0]["Iljo"],j["weather"][0]["Cloud"]]]

print(solar)
print("pd.DataFrame(solar)")
print(pd.DataFrame(solar))

predict_Ilsa = model.predict(pd.DataFrame(solar))
print("Ilsa")
# 어제 날씨를 기반으로 도출한 오늘의 발전량
print(predict_Ilsa[0])
val = predict_Ilsa[0]
ss = solar.copy()
type(ss)

solar[0].insert(7,val)
print(solar)
predict = model_p.predict(pd.DataFrame(solar))
print("predict")
print(predict)
predict = float(predict)
type(predict)


# In[ ]:





# In[111]:



url = "http://solarcharging.dothome.co.kr/WeatherPostApi.php?apicall=getinfo"
data = {'power':predict} 
res = requests.post(url, data=data)

