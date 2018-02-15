USE Gosuslugi;
DROP TABLE IF EXISTS contracts;
CREATE TABLE 
	contracts
		(primary key (regNum))
SELECT DISTINCT c.regNum,
	(SELECT max(versionNumber) FROM contract c1 WHERE c1.regNum=c.regNum GROUP BY c1.regNum) AS ver
FROM contract c
WHERE c.regNum IS NOT NULL;


