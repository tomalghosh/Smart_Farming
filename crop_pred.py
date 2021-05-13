#!/usr/bin/env python
# coding: utf-8

import numpy as np 
import pandas as pd 
import time
import  warnings

#sklearn import for prediction and training
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import MinMaxScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import confusion_matrix, accuracy_score, classification_report

warnings.simplefilter(action="ignore")

df = pd.read_csv('Datasets//apy_clean.csv')
df.head()

df.shape

x = df["State_Name"].unique()

df.columns

df.head()

new_df = df.groupby([df["State_Name"]=="Maharashatra", df["District_Name"]=="AKOLA", "Crop"]).mean()

class crop_predictions():

    def __init__(self):
        pass

    def major_crops(self, state_name, district_name):
        list_crops = []
        state_name = str.capitalize(state_name)
        district_name = str.upper(district_name)
        
        state_df = df[df["State_Name"]==state_name]
        district_df = state_df[state_df["District_Name"]==district_name]
        df_new = district_df.groupby(by="Crop").mean().sort_values(by="Production", ascending=False).reset_index()
        # for i in df_new["Crop"].unique():

            # list_crops.append("<i>"+i+"</>")
        
        return df_new["Crop"].unique().tolist()

    df_for_crops = pd.DataFrame()

    def crops_list(self, list_of_crops):

        crop_df = pd.read_csv('Datasets//Crop_Pred.csv')
        crop_df.drop('Unnamed: 0', axis=1, inplace=True)


        cf = []
        for i, crop in enumerate(list_of_crops):
            cf.append(crop_df[crop_df["Crop"] == crop])
            df_for_crops = pd.concat(cf, ignore_index=True)

        return df_for_crops

    def predict_crop(self, artifical_values, df_for_crops_list):

        X = df_for_crops_list.iloc[:, 1:]

        X = np.asarray(X)

        y = df_for_crops_list["Crop"]

        label_encoder = LabelEncoder()

        y = label_encoder.fit_transform(y)

        min_max_scaler = MinMaxScaler()

        scaled_X = min_max_scaler.fit_transform(X)

        start = time.time()
        
        crop_results = []
        if artifical_values in X.tolist():
            artifical_values = np.asarray([artifical_values])
            artifical_values = min_max_scaler.transform(artifical_values)
            crops = []
            for i in range(6):
                model = RandomForestClassifier()

                model.fit(scaled_X, y)

                pred = model.predict(artifical_values)
                crop = label_encoder.inverse_transform(pred)
                # print(i, crop[0])
                if crop in crops:
                     pass
                else:
                    crops.append(crop[0])
                crop_results = [str.upper(i) for i in crops]
            if len(crop_results) > 1:
                print("You can grow a variety of crops on your soil.")
                print(f"Your can grow {crop_results}")
            else:
                print(f"The Crop best suitable for your soil is : {crop_results}")
        else:
            print("The values entered are not suitable for any crop in this region.")
        end = time.time()
        print(f"Execution time : {end-start}s")

        if crop_results == None:
            pass
        else:
            return crop_results

# predict_crop([80, 40, 40, 5.50])

# def rec():
#     N = int(input("N:"))
#     P = int(input("P:"))
#     K = int(input("K:"))
#     pH = float(input("pH:"))

#     predict_crop([N, P, K, pH])



# obj1 = crop_predictions()

# listcrops = crop_predictions().major_crops("Maharashtra", "Akola")

# df_Crops = crop_predictions().crops_list(listcrops)

# pred = crop_predictions().predict_crop([80, 40, 10, 5.50], df_Crops)

# print(len(pred))



