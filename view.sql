CREATE VIEW itemsview AS
SELECT items.*, categories.* FROM items
INNER JOIN categories on items.items_cat = categories.categories_id

-- ///////////////////////////////////////////////////////////////////////////////

SELECT items1view.* , 1 AS favorite FROM items1view
INNER JOIN favorite on favorite.favorite_itemsid = items1view.items_id AND  favorite.favorite_usersid = 4
UNION ALL
SELECT *, 0 AS favorite FROM items1view
WHERE items_id NOT IN (SELECT items1view.items_id FROM items1view
INNER JOIN favorite on favorite.favorite_itemsid = items1view.items_id AND  favorite.favorite_usersid = 4)

--////////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE VIEW myfavorite AS
SELECT favorite.* , items.* , users.users_id FROM favorite 
INNER JOIN users ON users.users_id  = favorite.favorite_usersid
INNER JOIN items ON items.items_id  = favorite.favorite_itemsid

--////////////////////////////////////////////////////////////////////////////////////////was used by cart
CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.items_price) as itemsprice, COUNT(cart_itemsid) AS countitems , cart.* , items.* FROM 	cart
INNER JOIN items ON items.items_id = cart.cart_itemsid
GROUP BY cart.cart_itemsid, cart.cart_usersid

--// modified above code to subtract the discount from total to show in the cart page--USED ALSO BY ORDER table(added where cart_orders = 0)
CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.items_price - (items.items_price * items.items_discount / 100)) as itemsprice, COUNT(cart_itemsid) AS countitems , cart.* , items.* FROM cart
INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders = 0
GROUP BY cart.cart_itemsid, cart.cart_usersid;

--///////////////////////////////////////////////////////////////////////////////////////////
SELECT SUM(itemsprice) AS totalprice, SUM(countitems) as totalcount FROM `cartview`
WHERE cartview.cart_usersid = 4
GROUP BY cart_usersid; --/used by the view.php file in cart folder.

--/////////////////////////////////////////////////////////////////////////////////////////////
--/Used by the details page.
CREATE or REPLACE VIEW ordersdetailsview  as 
SELECT SUM(items.items_price - items.items_price * items_discount / 100) as itemsprice  , COUNT(cart.cart_itemsid) as countitems , cart.* , items.*   FROM cart 
INNER JOIN items ON items.items_id = cart.cart_itemsid 
WHERE cart_orders != 0 
GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders ;
--/used by the pending orders page and being sent as an argument to the details page to get the address details
CREATE  or REPLACE view ordersview AS 
SELECT orders.* , address.* FROM orders 
LEFT JOIN address ON address.address_id = orders.orders_address ;
--/Used to show topselling items
CREATE OR REPLACE VIEW itemstopselling AS
SELECT COUNT(cart_id) as countitems , cart.*, items.* , (items_price - (items_price * items_discount / 100 ))  as itemspricedisount FROM cart
INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders != 0
GROUP BY cart_itemsid;

--/to generate a sales report
CREATE OR REPLACE VIEW report_sales_revenue AS
SELECT
  DATE(orders_datetime) AS order_date,
  COUNT(*) AS total_orders,
  SUM(orders_price) AS total_sales,
  SUM(orders_pricedelivery) AS total_delivery_fees,
  SUM(orders_totalprice) AS total_revenue,
  orders_status
FROM orders
WHERE orders_status = 4
GROUP BY order_date, orders_status;

