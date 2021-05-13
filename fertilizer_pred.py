import numpy as np
import pandas as pd
import fertilizer_reccomendation as fr 

df = pd.read_csv("Datasets//fertilizer.csv")
# df.drop("Unnamed: 0", axis=1, inplace=True)

list_for_crops = []
list3 = df["Crop"].tolist()
for i in range(len(list3)):
	list_for_crops.append(str.lower(list3[i]))
	list_for_crops    
df["Crop"] = pd.Series(data=list_for_crops)
 
def compute_values(args):

    ip = []
    for i in args:
        ip.append(i)

#     #['rice', 30, 30, 30, 3.3]

    nr = int(df[df["Crop"] == ip[0]]["N"][df[df["Crop"] == ip[0]].index[0]])
    pr = int(df[df["Crop"] == ip[0]]["P"][df[df["Crop"] == ip[0]].index[0]])
    kr = int(df[df["Crop"] == ip[0]]["K"][df[df["Crop"] == ip[0]].index[0]])
    pHr = float(df[df["Crop"] == ip[0]]["pH"][df[df["Crop"] == ip[0]].index[0]])


    keys_for_rec = ["NHigh", "NLow", "PHigh", "PLow", "KHigh", "KLow"]

    #Recommendation for Nitrogen values
    if ip[1] > nr : 
        nrec = fr.fertilizer_dic["NHigh"]
    elif ip[1] == nr:
        nrec = f"\t<b>Nitrogen values of your soil is prefect for {ip[0]}</b>"
    else:
        nrec = fr.fertilizer_dic["NLow"]
   
    #Recommendation for Phosphorous Values
    if ip[2] > pr : 
        prec = fr.fertilizer_dic["PHigh"]
    elif ip[2] == pr:
        prec = f"\t<b>Phosphorous values of your soil is prefect for {ip[0]}</b>"
    else:
        prec = fr.fertilizer_dic["PLow"]

        #Recommendation for Potassium Values
    if ip[3] > kr : 
        krec = fr.fertilizer_dic["KHigh"]
    elif ip[3] == kr:
        krec = f"\t<b>Potassium values of your soil is prefect for {ip[0]}</b>"
    else:  
        krec = fr.fertilizer_dic["KLow"]

        #Recommendation for pH Values
    if ip[4] > pHr : 
        pHrec = fr.fertilizer_dic["pHHigh"]
    elif ip[4] == pHr:
        pHrec = f"\t<b>pH values of your soil is prefect for {ip[0]}</b>"
    else: 
        pHrec = fr.fertilizer_dic["pHLow"]
    reccommendations = [nrec, prec, krec, pHrec]

    return reccommendations