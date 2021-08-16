
db.laureates.aggregate([
    {$match: {"familyName.en": {$exists: true}}},
    {$unwind: "$nobelPrizes"},
    {$addFields: {c: 1}},
    {$group: {
        _id: "$familyName.en",
        totalCount: {$sum: "$c"}
    }},
    {$match:
        {
            totalCount: {$gte: 5}
        }
    },
    {$project: {
        _id: 0,
        "familyName": "$_id"
    }}
]);