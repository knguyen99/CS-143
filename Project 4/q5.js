db.laureates.aggregate([
    {$match: {"orgName.en": {$exists: true}}},
    {$unwind: "$nobelPrizes"},
    {$group: {
        _id: "$nobelPrizes.awardYear"
    }},
    {$count: "years"}
]);