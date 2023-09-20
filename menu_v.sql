CREATE VIEW menu_v AS
	SELECT f.*, me.meal_id, me.type, tod.description, m.day, 
		   DAYNAME(m.day) AS day_name, 
           WEEKDAY(m.day) AS weekday
		FROM food f
			RIGHT JOIN menu m ON f.food_id = m.food_id
			JOIN meal me ON me.meal_id = m.meal_id
			JOIN time_of_day tod ON tod.tod_id = me.tod_id
		ORDER BY m.meal_id;

select * from menu_v where day = '2023-09-18';