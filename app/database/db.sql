DROP FUNCTION IF EXISTS f_get_increment;
delimiter //
CREATE FUNCTION f_get_increment() RETURNS int 
DETERMINISTIC
BEGIN
  DECLARE last_increment_param int;

  SELECT last_increment INTO last_increment_param FROM increment_email_id;
  UPDATE increment_email_id SET last_increment = (last_increment_param + 1);

  RETURN (last_increment_param + 1);
END //
delimiter ;