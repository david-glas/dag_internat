    
CREATE VIEW menu_v AS
SELECT f.*, m.type, tod.description, me.day, DAYNAME(me.day) AS day_name, WEEKDAY(me.day) AS weekday
FROM food f
RIGHT JOIN food_meal fm ON f.food_id = fm.food_id
JOIN meal m ON m.meal_id = fm.meal_id
JOIN time_of_day tod ON tod.tod_id = m.tod_id
JOIN menu me ON me.fm_id = fm.fm_id
ORDER BY m.meal_id;

select * from menu_v where day = '2023-09-18';