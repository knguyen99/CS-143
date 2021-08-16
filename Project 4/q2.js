db.laureates.aggregate([
{$unwind: "$nobelPrizes"},
{$unwind: "$nobelPrizes.affiliations"},
{$match: {"nobelPrizes.affiliations.name.en": "CERN"}},
{$project: {"country": "$nobelPrizes.affiliations.country.en",
            "_id": 0
            }},
{$limit: 1}
]);