
import numpy as np 
import pandas as pd 
import matplotlib.pyplot as plt 
import seaborn as sns 
import warnings
import time 
import artificial_values as av


from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.preprocessing import LabelEncoder, Normalizer, MinMaxScaler
from sklearn.linear_model import LogisticRegression
from sklearn import tree
from sklearn.tree import DecisionTreeClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
from sklearn.tree import export_graphviz


# get_ipython().run_line_magic('matplotlib', 'inline')
# plt.style.use("dark_background")

warnings.simplefilter(action="ignore")


df = pd.read_csv("Datasets//crop_new_dataset.csv")
df.head()

def drop_cols(df, col):
    df.drop(col, axis=1, inplace=True)


#Droping Unnamed Cols
drop_cols(df, 'Unnamed: 0')

#Chechking for null values
df.isna().sum()

#Correlation of a each feature with the other features
plt.figure(figsize=(15,8))
sns.heatmap(data=df.corr(), annot=True)
plt.show()


#Spliting the data in to Features
X = df.iloc[:, 1:]
X.head()

#Target variable
y = df["Crop"]
y.head()

#Encoding the categorical values to a label
label_encoder = LabelEncoder()
y = label_encoder.fit_transform(y)


df.iloc[0,1:]

#plot displot of the features
# def plot_distplot(df):
#     for i in range(len(df.columns)):
#         sns.distplot(df[df.columns[i]])
#         plt.show()

# plot_distplot(X)



# def plot_boxplot(df):
#       for i in range(len(df.columns)):
#         sns.boxplot(df[df.columns[i]])
#         plt.show()

# plot_boxplot(X)


# X.head() 

#Scaling the data for training and testing purposes
min_max = MinMaxScaler()



scaled_X = min_max.fit_transform(X)



scaled_X[0:5]

X_train, X_test, y_train, y_test = train_test_split(scaled_X, y,
                                                   test_size=0.25,
                                                   shuffle=True,
                                                   random_state=0)

accuracy = []
def algo_test(ml_algo):
    start = time.time()
    ml_algo.fit(X_train, y_train)
    predict = ml_algo.predict(X_test)
    print(f"Training Score is {ml_algo.score(X_train, y_train)}")
    print(f"Accuracy Score is {accuracy_score(y_test, predict)}")
    print(classification_report(y_test, predict))
    accuracy.append(accuracy_score(y_test, predict))
    print(accuracy)
    end = time.time()
    print(f"Execution time Required {end-start}")

algos = [LogisticRegression(), KNeighborsClassifier(), DecisionTreeClassifier(), RandomForestClassifier()]


for i in algos:
    algo_test(i)


accuracy_df = pd.DataFrame(accuracy, columns=["Accuracy"])


accuracy_df["Algos"] = ["LogisticRegression()", "KNeighborsClassifier()", "DecisionTreeClassifier()", "RandomForestClassifier()"]


accuracy_df

plt.figure(figsize=(10,5))
sns.barplot(x=accuracy_df["Accuracy"], y=accuracy_df["Algos"])
plt.show()


def predict_crop(artifical_values):
    
    start = time.time()
    
    artifical_values = np.asarray([artifical_values])
    artifical_values = min_max.transform(artifical_values)
    model = RandomForestClassifier()
    model.fit(scaled_X, y)
    crops = []
    for i in range(6):
        pred = model.predict(artifical_values)
        crop = label_encoder.inverse_transform(pred)
        if crop in crops:
             pass
        else:
            crops.append(crop[0])
    print(f"The Crop best suitable for your soil is : {[str.upper(i) for i in crops]}")
    end = time.time()
    print(f"Execution time : {end-start}s")






# crops = []
# for i in range(6):
#     randomFC_model = RandomForestClassifier(n_estimators=3, criterion="gini") 
#     randomFC_model.fit(X, y_encoded)

#     sensor_value = np.asarray(sensor_value)

#     randomFC_model_y_pred = randomFC_model.predict([sensor_value])
#     crop = label_enc.inverse_transform(randomFC_model_y_pred)
#     if crop in crops:
#         pass
#     else:
#         crops.append(crop[0])
# print(crops)
# print(f"The Crop best suitable for your soil is : {[str.upper(i) for i in crops]}")
# end = time.time()
# print(f"Execution time : {end-start}s")

object_1 = av.generate_artificial_values()

sensor_value = object_1.values_for_crop_pred()
print(sensor_value)
predict_crop(sensor_value)


# clf = tree.DecisionTreeClassifier(criterion="entropy", max_depth=2)
# clf.fit(X_train_encoded, y_train)
# y_pred = clf.predict(X_test_encoded)
# print("Accuracy:", metrics.accuracy_score(y_test, y_pred))







