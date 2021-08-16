# dummy code for the converter in Python
import json
import csv

print("Hello, I am the JSON-to-Relation converter!")

laureates = {}
nobel_prizes = {}
affiliations = []

with open('/home/cs143/data/nobel-laureates.json') as data_file:
    data = json.load(data_file)
    for laureate in data["laureates"]:
        temp = []
        if(laureate.get('givenName') != None):
            temp.append(laureate.get('givenName').get('en'))
        if(laureate.get('orgName') != None):
            temp.append(laureate.get('orgName').get('en'))
        
        if(laureate.get('familyName') != None):
            temp.append(laureate.get('familyName').get('en'))
        else:
            temp.append("NULL")
        
        if(laureate.get('gender') != None):
            temp.append(laureate.get('gender'))
        else:
            temp.append("NULL")
        
        if(laureate.get('birth') != None):
            temp.append(laureate.get('birth').get('date'))
            if(laureate.get('birth').get('place').get('city') != None):
                temp.append(laureate.get('birth').get('place').get('city').get('en'))
            else:
                temp.append("NULL")
            if(laureate.get('birth').get('place').get('country') != None):
                temp.append(laureate.get('birth').get('place').get('country').get('en'))
            else:
                temp.append("NULL")
        if(laureate.get('founded') != None):
            temp.append(laureate.get('founded').get('date'))
            if(laureate.get('founded').get('place').get('city') != None):
                temp.append(laureate.get('founded').get('place').get('city').get('en'))
            else:
                temp.append("NULL")
            if(laureate.get('founded').get('place').get('country') != None):
                temp.append(laureate.get('founded').get('place').get('country').get('en'))
            else:
                temp.append("NULL")
        
        laureates[laureate["id"]] = temp
        
        for prize in laureate["nobelPrizes"]:
            temp2 = []
            temp2.append(laureate["id"])
            temp2.append(prize.get("awardYear"))
            temp2.append(prize.get("category").get("en"))
            temp2.append(prize.get("sortOrder"))
            temp2.append(prize.get("portion"))
            temp2.append(prize.get("dateAwarded"))
            temp2.append(prize.get("prizeStatus"))
            temp2.append(prize.get("motivation").get("en"))
            temp2.append(prize.get("prizeAmount"))
            nobel_prizes[(prize.get("awardYear"),prize.get("category").get("en"),laureate["id"])] = temp2
            if(prize.get("affiliations") != None):
                for affil in prize["affiliations"]:
                    temp3 = []
                    temp3.append(affil.get("name").get("en"))
                    temp3.append(laureate["id"])
                    temp3.append(prize.get("awardYear"))
                    temp3.append(prize.get("category").get("en"))
                    if(affil.get("city") != None):
                        temp3.append(affil.get("city").get("en"))
                    else:
                        temp3.append("NULL")

                    if(affil.get("country") != None):
                        temp3.append(affil.get("country").get("en"))
                    else:
                        temp3.append("NULL")
                    affiliations.append(temp3)             
with open("affiliations.del","w+") as f:
    csvWriter = csv.writer(f,delimiter=',')
    csvWriter.writerows(affiliations)
f.close()

a = []
for key in laureates:
    temp = []
    temp.append(key)
    for i in laureates[key]:
        temp.append(i)
    a.append(temp)

with open("laureates.del","w+") as f:
    csvWriter = csv.writer(f,delimiter=',')
    csvWriter.writerows(a)
f.close()

a = []
for key in nobel_prizes:
    temp = []
    for i in nobel_prizes[key]:
        temp.append(i)
    a.append(temp)

with open("nobelPrizes.del","w+") as f:
    csvWriter = csv.writer(f,delimiter=',')
    csvWriter.writerows(a)
f.close()

