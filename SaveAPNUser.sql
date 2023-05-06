SaveAPNUser:BEGIN
               DECLARE exist INT DEFAULT 0;
               DECLARE existEmailregid INT DEFAULT 0;
               select count(*)  into exist from  `apn_users` where apn_regid=p_regid;
               select count(*)  into existEmailregid from  `apn_users` where apn_regid=p_regid and email=p_email;
if (existEmailregid > 0) then
update  `apn_users` set 
         name=p_name, 
         active=COALESCE(p_active, active), active_rain_etc=COALESCE(p_active_rain_etc, active_rain_etc), active_tips=COALESCE(p_active_tips, active_tips), active_dust=COALESCE(p_active_dust, active_dust),
         active_uv=COALESCE(p_active_uv, active_uv),
         active_dry=COALESCE(p_active_dry, active_dry),
         lang=COALESCE(p_lang, lang), 
         updated_at=SYSDATE() where apn_regid=p_regid and email=p_email;
end if;
if (exist > 0) then
         update  `apn_users` set 
         name=p_name, 
         email=p_email, 
         active=COALESCE(p_active, active), active_rain_etc=COALESCE(p_active_rain_etc, active_rain_etc), active_tips=COALESCE(p_active_tips, active_tips), active_dust=COALESCE(p_active_dust, active_dust),
         active_uv=COALESCE(p_active_uv, active_uv),
         active_dry=COALESCE(p_active_dry, active_dry),
         lang=COALESCE(p_lang, lang), 
         updated_at=SYSDATE() where apn_regid=p_regid;
               
end if;

if (exist = 0 and existEmailregid = 0) then
     INSERT INTO `apn_users` (name, email, apn_regid, created_at, lang, active, active_rain_etc, active_tips, active_dust, active_uv, active_dry, dailyforecast) VALUES(p_name, p_email, p_regid, SYSDATE(), COALESCE(p_lang, 1), p_active, p_active_rain_etc, p_active_tips, p_active_dust, p_active_uv, p_active_dry, p_dailyforecast);
end if;

if (p_dailyforecast > 0) THEN
	update  `apn_users`
    set dailyforecast=p_dailyforecast
    where 
    apn_regid=p_regid;
end if;

if (p_email is null or p_email = '') then
LEAVE SaveAPNUser;
end if;

select count(*) into exist from Subscriptions where email=p_email;
select count(*)  into existEmailregid from  `Subscriptions` where reg_id=p_regid and email=p_email;

if (existEmailregid > 0) THEN
	update Subscriptions
    set updatedAt = now()
    WHERE 
    email=p_email and reg_id = p_regid;
    LEAVE SaveAPNUser;
end if;

if (exist > 0) THEN
    update Subscriptions
    set reg_id = p_regid,
    updatedAt = now()
    WHERE 
    email=p_email;
ELSE
    INSERT INTO `Subscriptions` (guid, email, approved, reg_id) 	
    VALUES(UUID_SHORT(), p_email ,0, p_regid);
end if;

	      END