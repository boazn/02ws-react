SELECT MAX(  `HiTemp` ) , DATE
FROM  `archivemin` 
WHERE (
DATEDIFF(  `Date` , DATE(  '1998-12-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1999-01-01' ) ) <0
)
OR (
DATEDIFF(  `Date` , DATE(  '1997-12-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1998-01-01' ) ) <0
)
OR (
DATEDIFF(  `Date` , DATE(  '1996-12-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1997-01-01' ) ) <0
)
GROUP BY DATE
ORDER BY MAX(  `HiTemp` ) DESC 
LIMIT 0 , 30







select sumrain, month FROM  
(
SELECT SUM(  `Rain` )  sumrain , '1994-01'  month
FROM  `archivemin` 
WHERE  `Rain` IS NOT NULL 
AND (
DATEDIFF(  `Date` , DATE(  '1994-01-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1994-02-01' ) ) <0)
union all
SELECT SUM(  `Rain` ) sumrain ,   '1994-02'  month
FROM  `archivemin` 
WHERE  `Rain` IS NOT NULL 
AND (
DATEDIFF(  `Date` , DATE(  '1994-02-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1994-03-01' ) ) <0)
union all
SELECT SUM(  `Rain` ) sumrain ,   '1994-03' month
FROM  `archivemin` 
WHERE  `Rain` IS NOT NULL 
AND (
DATEDIFF(  `Date` , DATE(  '1994-03-01' ) ) >=0
AND DATEDIFF(  `Date` , DATE(  '1994-04-01' ) ) <0)
) ar
order by sumrain DESC