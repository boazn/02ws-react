update `surveyresult`
set `value` = 6 
WHERE  `survey_id` =2
AND  `value` = 5
AND `temp` > 26

SELECT * 
FROM  `surveyresult` 
WHERE  `survey_id` =2
AND  `value` =2
order by `temp`

SELECT COUNT( * ) ,  `value` 
FROM  `surveyresult` 
WHERE  `survey_id` =2
GROUP BY  `value` 



SELECT MAX(  `HiTemp` ) ,  `Date` 
FROM  `ar200709` 
GROUP BY  `Date` 
ORDER BY MAX(  `HiTemp` ) ASC 
LIMIT 0 , 30

SELECT MIN(  `LowTemp` ) ,  `Date` 
FROM  `ar200709` 
GROUP BY  `Date` 
ORDER BY MIN(  `LowTemp` ) DESC 
LIMIT 0 , 30




SELECT MAX(  `HiTemp` ) ,  `Date` 
FROM (

SELECT  `HiTemp` ,  `Date` 
FROM  `ar200709` 
UNION 
SELECT  `HiTemp` ,  `Date` 
FROM  `ar200609`
)aa
GROUP BY  `Date` 
ORDER BY MAX(  `HiTemp` ) ASC 
LIMIT 0 , 10