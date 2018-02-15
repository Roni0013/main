USE Gosuslugi;
DROP TABLE IF EXISTS contract_ids;
CREATE TABLE 
	contract_ids (
		idauto integer auto_increment,
        primary key (idauto),
        INDEX (regNum)
        )
SELECT distinct id,regNum from contract WHERE id IS NOT NULL