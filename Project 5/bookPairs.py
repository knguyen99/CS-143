from pyspark import SparkContext
import itertools
sc = SparkContext("local", "bookPairs")
lines = sc.textFile("/home/cs143/data/goodreads.user.books")

def combo_books(line):
    books = line.split(":")[1].split(",")
    ret = []
    for book in books:
        ret.append(int(book))
    return list(itertools.combinations(ret,2))

def order_combos(tup):
    return ((min(tup), max(tup)),1)

line_combos = lines.flatMap(combo_books)
ordered = line_combos.map(order_combos)
counts = ordered.reduceByKey(lambda x,y: x+y)
filtered = counts.filter(lambda tup: tup[1] >20)
filtered.saveAsTextFile("output")
