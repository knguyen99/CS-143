SELECT first, last FROM Actor, Movie, MovieActor
WHERE Actor.id = MovieActor.aid AND MovieActor.mid = Movie.id AND title = 'Die Another Day';