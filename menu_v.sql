CREATE VIEW menu_v AS
	SELECT m.menu_id, f.*, me.meal_id, me.type,  m.day, tod.description, tod.tod_id,
		   DAYNAME(m.day) AS day_name, 
           WEEKDAY(m.day) AS weekday
		FROM food f
			RIGHT JOIN menu m ON f.food_id = m.food_id
			JOIN meal me ON me.meal_id = m.meal_id
			JOIN time_of_day tod ON tod.tod_id = me.tod_id
		ORDER BY m.meal_id;

select * from menu_v where day = '2023-10-13';

select * from user_menu;

drop view menu_v;

use dag;

select mv.*, um.*
                    from menu_v mv left join user_menu um using (menu_id)
                    where day = '2023-10-13'
                    order by meal_id;
                    
select *, (select user_id from user_menu 
				where menu_id = mv.menu_id 
				and user_id = 4) user_id
	from menu_v mv
	where day = '2023-10-13';
    
select * from menu_v
inner join user_menu using(menu_id);

select * 
	from menu_v mv left join user_menu um using (menu_id)
	where day = '2023-10-13'
	  and (user_id = 4
		   or user_id is null)
	order by meal_id;

    
