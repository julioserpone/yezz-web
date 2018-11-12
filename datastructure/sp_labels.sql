CREATE PROCEDURE sayyezz.sp_labels (IN langcode VARCHAR(5))
BEGIN

DECLARE sqlSentence varchar(20000) DEFAULT '';

SET group_concat_max_len = 15000;

SELECT 
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'MAX(IF(la.code = '',  la.code, '', la.value, NULL)) AS ',  la.code
    )
  ) INTO sqlSentence
FROM labels la
INNER JOIN languages lang ON la.language_id = lang.id
WHERE lang.code = langcode
ORDER BY la.code;

SET sqlSentence = CONCAT('SELECT ', sqlSentence , ' 
                   FROM labels la
                   LEFT JOIN languages lang 
                    ON la.language_id = lang.id
                   WHERE lang.code = '', langcode, ''
                   GROUP BY lang.id');
        
SET @sql = sqlSentence;

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
	
END