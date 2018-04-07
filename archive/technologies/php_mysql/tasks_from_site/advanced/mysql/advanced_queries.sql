SELECT * FROM workers WHERE name IN('Вася', "Коля") AND id IN(65,66,67,68,69,75,76,77,78,79,85,86,87,88,89) AND salary IN(1000, 400)
SELECT * FROM workers WHERE id BETWEEN 65 AND 75 AND salary BETWEEN 500 AND 1000 
SELECT id as 'USER-ID', name as 'USER-NAME', salary AS 'Зарплата' FROM workers
SELECT DISTINCT age FROM workers
SELECT min(salary) FROM workers
SELECT max(salary) FROM workers
SELECT SUM(salary) FROM workers WHERE id IN(65,66,67,68)
SELECT AVG(salary) FROM workers
SELECT * FROM workers WHERE date>NOW()
INSERT INTO workers (name, date) VALUES ('Вася', NOW())
INSERT INTO workers (name, date) VALUES ('Петя', CURDATE())
INSERT INTO workers (name, date) VALUES ('Коля', CURTIME())
SELECT * FROM workers WHERE YEAR(date) = 2018
SELECT * FROM workers WHERE MONTH(date) = 3 
SELECT * FROM workers WHERE DAY(date) = 19 AND HOUR(date) < 21 
SELECT * FROM workers WHERE HOUR(date) in (1, 2, 3 ,19,20,21,22,23)
SELECT * FROM workers WHERE WEEKDAY(date) = 0
SELECT *, DAY(date) as day, MONTH(date) as month, YEAR(date) as year FROM workers
SELECT *, EXTRACT(day from date) as day, EXTRACT(MONTH from date) as month, EXTRACT(YEAR from date) as year FROM workers
SELECT DATE_FORMAT(date, "%d.%m.%Y") FROM workers
SELECT date + INTERVAL 1 DAY FROM workers
SELECT DATE_ADD(date, INTERVAL 1 DAY) FROM workers
SELECT DATE_ADD(date, INTERVAL -1 DAY) FROM workers
SELECT DATE_SUB(date, INTERVAL 1 DAY) FROM workers
SELECT DATE_ADD(date, INTERVAL '1 2' DAY_HOUR) FROM workers
SELECT date + INTERVAL '1 2' YEAR_MONTH FROM workers
SELECT date + INTERVAL '1 2 3' DAY_MINUTE FROM workers
SELECT DATE_ADD(DATE_SUB(date, INTERVAL 2 HOUR), INTERVAL 1 DAY) FROM workers
SELECT 3 FROM workers
SELECT 3 as 'asdas' FROM workers
SELECT age + salary as 'res' FROM workers
SELECT * FROM workers WHERE (DAY(date)+MONTH(date)) < 20 
SELECT LEFT(`descr`, 5) FROM `workers` 
SELECT RIGHT(`descr`, 5) FROM `workers` 
SELECT SUBSTRING(`descr`, 2, 10) FROM `workers` 
SELECT id, name FROM `workers` UNION SELECT id, name FROM users2
SELECT CONCAT(salary, age) as 'RES' FROM `workers` 
SELECT CONCAT_WS('-', salary, age) as 'RES' FROM `workers` 
SELECT CONCAT(LEFT(name, 3), '...') as 'RES' FROM `workers` 
SELECT age, MIN(salary) as min FROM workers GROUP BY age
SELECT salary, MAX(age) as max FROM workers GROUP BY salary
SELECT salary, GROUP_CONCAT(name) as Names FROM workers GROUP BY salary
SELECT salary, GROUP_CONCAT(id SEPARATOR '-') as "ID'S" FROM workers GROUP BY salary
SELECT * FROM workers WHERE salary > (SELECT AVG(salary) from workers)
SELECT * FROM workers WHERE age < (SELECT (AVG(age)/2)*3 from workers)
SELECT * FROM workers WHERE salary = (SELECT MIN(salary) from workers)
SELECT *, (MAX(salary) - MIN(salary))/2 as 'res' FROM workers
SELECT forum_answers.message, users2.login FROM forum_answers 
	JOIN users2 ON forum_answers.id_of_theme = users2.id 
	
SELECT forum_answers.message, users2.login FROM forum_answers 
	RIGHT JOIN users2 ON forum_answers.id_of_theme = users2.id 
	
SELECT forum_answers.message, users2.login FROM forum_answers 
	LEFT JOIN users2 ON forum_answers.id_of_theme = users2.id 
	
SELECT pages.text, subcategories.name, categories.name FROM pages 
	LEFT JOIN subcategories ON pages.cat = subcategories.id 
	LEFT JOIN categories ON subcategories.parent_cat_id = categories.id 

CREATE DATABASE test1
DROP DATABASE test1122

CREATE TABLE table1(
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   login VARCHAR(255),
   salary INT(6),
   age INT(6),
   date DATE NOT NULL,
   primary key (Id)
)
RENAME TABLE table2 TO table3
DROP TABLE table3
ALTER TABLE table1 ADD status INT
ALTER TABLE table1 DROP age
ALTER TABLE table1 CHANGE COLUMN user_login login INT
ALTER TABLE table1 MODIFY `salary` varchar(255)
TRUNCATE table1

DROP DATABASE test1123;CREATE DATABASE test1123


SELECT father_son.name, father.name as father FROM `father_son` 
LEFT JOIN father_son as father ON father_son.father_id = father.id 

SELECT city_from.name as 'from', city_to.name as 'to' FROM `routes` 
LEFT JOIN city as city_from ON routes.from_city_id = city_from.id 
LEFT JOIN city as city_to ON routes.to_city_id = city_to.id 

SELECT * FROM goods WHERE goods.category_id IN (SELECT categories.id FROM categories WHERE categories.name = 'Овощи' OR categories.name = 'Мясо')

/*------------------------------------------------------------------------------*/
-- 1
(
-- #1. достать товары вместе с категориями:
(
	SELECT * FROM goods LEFT JOIN category ON goods.categoryId = category.id;
)
-- #2. достать товары из категории 'Овощи':
(
	SELECT * FROM goods 
	INNER JOIN category ON goods.categoryId = category.id WHERE category.name = "Овощи";
	
	SELECT * FROM goods WHERE goods.category_id = 
	(SELECT categories.id FROM categories WHERE categories.name = 'Овощи');
)
-- #3. достать товары из категорий 'Овощи', 'Мясо', 'Морепродукты':
(
	SELECT * FROM goods WHERE goods.category_id IN 
	(SELECT categories.id FROM categories WHERE categories.name IN ('Овощи', "Мясо", "Морепродукты"));
	
	SELECT * FROM goods 
	JOIN categories ON goods.category_id = categories.id WHERE categories.name IN 
	('Овощи', "Мясо", "Морепродукты");
)
-- #4. достать все категории (без товаров, только названия категорий):
(
	SELECT name FROM category;
)
-- #5. достать все категории, в которых есть товары (без товаров, только названия категорий, без дублей):
(
	SELECT categories.name FROM categories WHERE 0 < 
	(SELECT COUNT(1) FROM goods WHERE goods.category_id = categories.id);
	
	SELECT DISTINCT name FROM category INNER JOIN 'goods' ON category.Id = goods.category_id;
)
)
-- 2
(
-- #1. достать товары вместе с категориями:
(
	SELECT goods.name, subcategories.name, categories.name FROM goods 
	LEFT JOIN subcategories ON goods.sub_category_id = subcategories.id 
	LEFT JOIN categories ON subcategories.category_id = categories.id;
)
-- #2. достать товары из категории 'Овощи':
(
	SELECT goods.name, subcategories.name, categories.name FROM goods 
	LEFT JOIN subcategories ON goods.sub_category_id = subcategories.id 
	LEFT JOIN categories ON subcategories.category_id = categories.id WHERE categories.name = 'Консервы';
	
	SELECT * FROM goods WHERE goods.sub_category_id IN 
	(SELECT id FROM subcategories WHERE category_id = 
	(SELECT id FROM categories WHERE name = 'Консервы'))
	
)
-- #3. достать товары из категорий 'Овощи', 'Мясо', 'Морепродукты':
(
	SELECT goods.name, subcategories.name, categories.name FROM goods 
	LEFT JOIN subcategories ON goods.sub_category_id = subcategories.id 
	LEFT JOIN categories ON subcategories.category_id = categories.id WHERE categories.name IN ('Овощи', "Мясо", "Морепродукты");

	SELECT * FROM goods WHERE goods.sub_category_id IN 
	(SELECT id FROM subcategories WHERE category_id = 
	(SELECT id FROM categories WHERE name IN ('Овощи', "Мясо", "Морепродукты")))
)
)
-- 3
(
-- 
(

)
)



