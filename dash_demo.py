import os
import numpy as np 
import pandas as pd 
import dash 
import dash_core_components as dcc 
import dash_html_components as html
import dash_table
import json

from dash.dependencies import Input, Output
from flask import send_from_directory

import plotly.express as px



df = pd.read_csv("Datasets//apy_clean.csv")
# df.drop('Unnamed: 0', axis=1, inplace=True)

#initalizing the dash 
app = dash.Dash(__name__, requests_pathname_prefix='/dashboard/')

app.config.suppress_callback_exceptions = True
app.css.config.serve_locally = True
app.scripts.config.serve_locally = True

#Designing the app layout 
app.layout = html.Div(id="crop-res",children=[

	# html.Link(rel="stylesheet", href="/assets/style.css"),

	html.H1("Vizualization for Smart Farming.", className="h1"),

	#Initalzing and setting the graph
	#elemnts and the parameters
	html.Hr(),
	html.Br(),
	
	html.Div(className="div2",
		children=[
		html.Label("Enter name of a state :", className="label_main"),
		html.Br(),
		dcc.Input(style={"textAlign":"center"},
		 type="text", id="state_name", placeholder="Maharashtra.."),
		dcc.Graph(id="district_wise_prod")
		]),

	html.Hr(),
	html.Br(),

	html.Div(className="div3", 
		children=[
		html.Label("Enter the State Name:"),
		dcc.Input(type="text", id="state_name_for_crop", placeholder="Kerala"),
		html.Br(),
		html.Br(),
		html.Label("Enter a Crop Name:"),
		dcc.Input(type="text", id="crop_per_district", placeholder="Rice"),
		dcc.Graph(id="crop_per_state"),
		]),

	html.Hr(),
	html.Br(),

	html.Div(className="div4", children=[
		html.Div(className="row",
		children=[
		html.Label("Enter the State Name:"),
		dcc.Input(type="text", id="state_name_for_district", placeholder="Maharashtra"),
 		

 		html.Label("Enter a District Name:"),
		dcc.Input(type="text", id="district_name", placeholder="Akola")]),
		dcc.Graph(id="district")
		]), 

	html.Div(className="row",
		children=[
			html.Div(className="div1 col-6", children=[
			html.H2("Map of India with total production in each state."),
			html.Label("Enter name of a Crop :", className="label_main"),
			html.Br(),
			dcc.Input(style={"textAlign":"center"},type="text", id="crop", placeholder="Rice.."),
			dcc.Graph(id="map_india"),
			html.Div(className="col-6", children=[
				html.P("""As of 2011, India had a large and diverse agricultural sector, accounting, on average, 
					for about 16% of GDP and 10% of export earnings. 
					India's arable land area of 159.7 million hectares (394.6 million acres) is the second largest in the world, after the United States. 
					Its gross irrigated crop area of 82.6 million hectares (215.6 million acres) is the largest in the world. 
					India is among the top three global producers of many crops, including wheat, rice, pulses, cotton, peanuts, fruits and vegetables. 
					Worldwide, as of 2011, India had the largest herds of buffalo and cattle, 
					is the largest producer of milk and has one of the largest and fastest growing poultry industries""")
				]),
			]),
		]),
	])

#retriving values from the input elements in the layout
#and proccessing the dataframe 
#also sending the output
@app.callback(
	Output('district_wise_prod', 'figure'),
	[Input('state_name', 'value'),
	# Input('district_name', 'value')
	]
	)

#function to process the above callback query
def district_wise_prod(state_name):

	if state_name == None:
		state_df = df[df["State_Name"]== "Maharashtra"]
		production_df = state_df.groupby("District_Name", axis=0).mean().sort_values(by="Production", ascending=False).reset_index()

		bar_graph = px.bar(data_frame=production_df, x="District_Name", y="Production", color="District_Name", title=f"Total Production for Maharashtra", template="plotly_dark")
	else:
		state_name = str.capitalize(state_name)
		state_df = df[df["State_Name"]==state_name]
		production_df = state_df.groupby("District_Name", axis=0).mean().sort_values(by="Production", ascending=False).reset_index()

		bar_graph = px.bar(data_frame=production_df, x="District_Name", y="Production", color="District_Name", title=f"Total Production for {state_name}", template="plotly_dark")

	return bar_graph

@app.callback(
	Output('crop_per_state', 'figure'),
	[Input('state_name_for_crop', 'value'),
	Input('crop_per_district', 'value')]
	)

def particular_crop_prod(state_name, crop):
	if state_name==None and crop==None:
		

		state_df = df[df["State_Name"]=="Maharashtra"]
		crop_df = state_df[state_df["Crop"]=="Rice"].groupby("District_Name", axis=0).mean().sort_values(by="Production", ascending=False).reset_index()

		fig = px.bar(data_frame=crop_df, x="District_Name", y="Production", color='District_Name',
			title=f"Rice Production/District of Maharashtra", template="plotly_dark")
	else:
		state_df = df[df["State_Name"]==state_name]
		crop_df = state_df[state_df["Crop"]==crop].groupby("District_Name", axis=0).mean().sort_values(by="Production", ascending=False).reset_index()


		fig = px.bar(data_frame=crop_df, x="District_Name", y="Production", color='District_Name', 
			title=f"{str.capitalize(crop)} Production/District of {str.capitalize(state_name)}", template="plotly_dark")

	return fig

@app.callback(
	Output('district', "figure"),
	[Input('state_name_for_district', 'value'),
	Input('district_name', 'value')]
	)

def major_crops_in_particular_district(state_name, district_name):
	if state_name==None and district_name==None:
		state_df = df[df["State_Name"]=="Maharashtra"]
		district_df = state_df[state_df["District_Name"]=="AKOLA"]
		df_new = district_df.groupby(by="Crop").mean().sort_values(by="Production", ascending=False).reset_index()

		fig = px.bar(data_frame=df_new[:20], y="Crop", x="Production", color="Production", template="plotly_dark")
		fig.update_layout(title=f"The Top 20 most crop grown in the district Akola of Maharashtra.")
	else:
		state_name = str.capitalize(state_name)
		district_name = str.upper(district_name)
		state_df = df[df["State_Name"]==state_name]
		district_df = state_df[state_df["District_Name"]==district_name]
		df_new = district_df.groupby(by="Crop").mean().sort_values(by="Production", ascending=False).reset_index()

		fig = px.bar(data_frame=df_new[:20], y="Crop", x="Production", color="Production", template="plotly_dark")
		fig.update_layout(title=f"The Top 20 most crop grown in the district {district_name} of {state_name}.", )
	return fig

@app.callback(
	Output('map_india', 'figure'),
	[Input('crop', "value")])

def map_india(crop):

	f = open("Datasets//states_india.geojson")
	k = json.load(f)
	a = k["features"]
	li2 = []
	for i in range(36):
		li2.append(a[i]["properties"]["st_nm"])
	# li2 = np.asarray(li2)
	new_df = df.groupby(["State_Name", "Crop"], axis=0).mean().sort_values(by="Production", ascending=False).reset_index()
	if crop==None:
		new_df = new_df[new_df["Crop"]=="Rice"]

		fig = px.choropleth(
		new_df,
		geojson=k,
		featureidkey="properties.st_nm",
		locations='State_Name',
		color="Production",
		color_continuous_scale="viridis",
		title=f"Production of Rice throughout India.",
		template="plotly_dark"
		)
		fig.update_geos(fitbounds="locations", visible=False)
	else:
		new_df = new_df[new_df["Crop"]==crop]

		#Plotting the map and distribution of total crop production in each state
		fig = px.choropleth(
		new_df,
		geojson=k,
		featureidkey="properties.st_nm",
		locations='State_Name',
		color="Production",
		color_continuous_scale='viridis',
		title=f"Production of {str.capitalize(crop)} throughout India.",
		template="plotly_dark"
		)
		fig.update_geos(fitbounds="locations", visible=False)

	return fig

# path fot the static/assets file 
@app.server.route('/assets/<path>')
def static_file(path):
    static_folder = os.path.join(os.getcwd(), 'assets')
    return send_from_directory(static_folder, path)

# if __name__ == "__main__":
# 	app.run_server(debug=True)

