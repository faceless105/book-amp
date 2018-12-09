-- Get the area of our polygons
SELECT * , AREA( poly ) AS  "Area" FROM  `poly`

-- generate the contains, intersects, overlaps, and within by comparing polygon 5 to all the polygons.
SELECT p1.name, p2.name, ST_Contains(p1.poly, p2.poly), ST_Intersects(p1.poly, p2.poly), ST_Overlaps(p1.poly, p2.poly), ST_Within(p1.poly, p2.poly) FROM `poly` p1, `poly` p2 WHERE p1.id = 5
