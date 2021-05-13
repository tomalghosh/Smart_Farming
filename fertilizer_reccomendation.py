fertilizer_dic = {
'NHigh': """<b>The N value of soil is high and might give rise to weeds.</b>
<br/> Please consider the following suggestions:
<br/>1. <i>Manure – adding manure is one of the simplest ways to amend your soil with nitrogen. Be careful as there are various types of manures with varying degrees of nitrogen.
<br/>2. <i>Coffee grinds – use your morning addiction to feed your gardening habit! Coffee grinds are considered a green compost material which is rich in nitrogen. Once the grounds break down, your soil will be fed with delicious, delicious nitrogen. An added benefit to including coffee grounds to your soil is while it will compost, it will also help provide increased drainage to your soil.
<br/>3. <i>Plant nitrogen fixing plants – planting vegetables that are in Fabaceae family like peas, beans and soybeans have the ability to increase nitrogen in your soil
<br/>4. Plant ‘green manure’ crops like cabbage, corn and brocolli
<br/>5. <i>Use mulch (wet grass) while growing crops - Mulch can also include sawdust and scrap soft woods""",

'NLow': """<b>The N value of your soil is low.</b>
<br/> Please consider the following suggestions:
<br/>1. <i>Add sawdust or fine woodchips to your soil – the carbon in the sawdust/woodchips love nitrogen and will help absorb and soak up and excess nitrogen.
<br/>2. <i>Plant heavy nitrogen feeding plants – tomatoes, corn, broccoli, cabbage and spinach are examples of plants that thrive off nitrogen and will suck the nitrogen dry.
<br/>3. <i>Water – soaking your soil with water will help leach the nitrogen deeper into your soil, effectively leaving less for your plants to use.
<br/>4. <i>Sugar – In limited studies, it was shown that adding sugar to your soil can help potentially reduce the amount of nitrogen is your soil. Sugar is partially composed of carbon, an element which attracts and soaks up the nitrogen in the soil. This is similar concept to adding sawdust/woodchips which are high in carbon content.
<br/>5. <i>Add composted manure to the soil.
<br/>6. <i>Plant Nitrogen fixing plants like peas or beans.
<br/>7. <i>Use NPK fertilizers with high N value.
<br/>8. <i>Do nothing – It may seem counter-intuitive, but if you already have plants that are producing lots of foliage, it may be best to let them continue to absorb all the nitrogen to amend the soil for your next crops.""",

'PHigh': """<b>The P value of your soil is high.</b>
<br/> Please consider the following suggestions:
<br/>1. <i>Avoid adding manure</i> – manure contains many key nutrients for your soil but typically including high levels of phosphorous. Limiting the addition of manure will help reduce phosphorus being added.
<br/>2. <i>Use only phosphorus-free fertilizer</i> – if you can limit the amount of phosphorous added to your soil, you can let the plants use the existing phosphorus while still providing other key nutrients such as Nitrogen and Potassium. Find a fertilizer with numbers such as 10-0-10, where the zero represents no phosphorous.
<br/>3. <i>Water your soil</i> – soaking your soil liberally will aid in driving phosphorous out of the soil. This is recommended as a last ditch effort.
<br/>4. Plant nitrogen fixing vegetables to increase nitrogen without increasing phosphorous (like beans and peas).
<br/>5. Use crop rotations to decrease high phosphorous levels""",

'PLow': """<b>The P value of your soil is low.</b>
<br/> Please consider the following suggestions:
<br/>1. <i>Bone meal</i> – a fast acting source that is made from ground animal bones which is rich in phosphorous.
<br/>2. <i>Rock phosphate</i> – a slower acting source where the soil needs to convert the rock phosphate into phosphorous that the plants can use.
<br/>3. <i>Phosphorus Fertilizers</i> – applying a fertilizer with a high phosphorous content in the NPK ratio (example: 10-20-10, 20 being phosphorous percentage).
<br/>4. <i>Organic compost</i> – adding quality organic compost to your soil will help increase phosphorous content.
<br/>5. <i>Manure</i> – as with compost, manure can be an excellent source of phosphorous for your plants.
<br/>6. <i>Clay soil</i> – introducing clay particles into your soil can help retain & fix phosphorus deficiencies.
<br/>7. <i>Ensure proper soil pH</i> – having a pH in the 6.0 to 7.0 range has been scientifically proven to have the optimal phosphorus uptake in plants.
<br/>8. If soil pH is low, add lime or potassium carbonate to the soil as fertilizers. Pure calcium carbonate is very effective in increasing the pH value of the soil.
<br/>9. If pH is high, addition of appreciable amount of organic matter will help acidify the soil. Application of acidifying fertilizers, such as ammonium sulfate, can help lower soil pH""",

'KHigh': """<b>The K value of your soil is high</b>.
<br/> Please consider the following suggestions:
<br/>1. <i>Loosen the soil</i> deeply with a shovel, and water thoroughly to dissolve water-soluble potassium. Allow the soil to fully dry, and repeat digging and watering the soil two or three more times.
<br/>2. <i>Sift through the soil</i>, and remove as many rocks as possible, using a soil sifter. Minerals occurring in rocks such as mica and feldspar slowly release potassium into the soil slowly through weathering.
<br/>3. <i>Stop applying potassium-rich commercial fertilizer. Apply only commercial fertilizer that has a '0' in the final number field. Commercial fertilizers use a three number system for measuring levels of nitrogen, phosphorous and potassium. The last number stands for potassium. Another option is to stop using commercial fertilizers all together and to begin using only organic matter to enrich the soil.
<br/>4. <i>Mix crushed eggshells, crushed seashells, wood ash or soft rock phosphate to the soil to add calcium. Mix in up to 10 percent of organic compost to help amend and balance the soil.
<br/>5. <i>Use NPK fertilizers with low K levels and organic fertilizers since they have low NPK values.
<br/>6. <i>Grow a cover crop of legumes that will fix nitrogen in the soil. This practice will meet the soil’s needs for nitrogen without increasing phosphorus or potassium.
""",

'KLow': """<b>The K value of your soil is low.</b>
<br/>Please consider the following suggestions:
<br/>1. <i>Mix in muricate of potash or sulphate of potash
<br/>2. <i>Try kelp meal or seaweed
<br/>3. <i>Try Sul-Po-Mag
<br/>4. <i>Bury banana peels an inch below the soils surface
<br/>5. <i>Use Potash fertilizers since they contain high values potassium
""",

'pHHigh': """
<b>pH <i>value of your soil is high.</b>
<br/>1.<i>Two materials commonly used for lowering the soil pH are aluminum sulfate and sulfur. 
<br/>2.<i>These can be found at a garden supply center. Aluminum sulfate will change the soil pH instantly because the aluminum produces the acidity as soon as it dissolves in the soil. Sulfur, however, requires some time for the conversion to sulfuric acid with the aid of soil bacteria. 
<br/>3.<i>The conversion rate of the sulfur is dependent on the fineness of the sulfur, the amount of soil moisture, soil temperature and the presence of the bacteria. 
<br/>4.<i>Depending on these factors, the conversion rate of sulfur may be very slow and take several months if the conditions are not ideal. For this reason, most people use the aluminum sulfate.
""",

'pHLow': """
<b>pH value of your soil is low.</b>
<br/>1.<i>Selecting a Liming Material: Homeowners can choose from four types of ground limestone products: pulverized, granular, pelletized and hydrated. Pulverized lime is finely ground. 
<br/>2.<i>The finer the grind of the limestone the faster it will change the soil pH value. 
<br/>3.<i>Hydrated lime should be used with caution since it has a greater ability to neutralize soil acidity than regular limestone.
<br/>4.<i>Wood Ashes: Wood ashes can be used to raise the soil pH. 
<br/>5.<i>They contain fairly high amounts of potassium & calcium, and small amounts of phosphate, boron and other elements.    
"""

}

# print(fertilizer_dic['pHLow'])