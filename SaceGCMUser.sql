SaveGCMUser:BEGIN
DECLARE exist INT DEFAULT 0;
DECLARE idToRemove INT DEFAULT 0;
DECLARE v_fcm INT DEFAULT 1;
  select count(*)  into exist from  `fcm_users` where gcm_regid=p_regid;
  
if (exist > 0) then
         update  `fcm_users` set 
         name=p_name, 
         email=p_email,
         lang=COALESCE(p_lang, lang),
         active=COALESCE(p_active,active),
         active_rain_etc=COALESCE(p_active_rain_etc,
                                  active_rain_etc),  
         active_tips=COALESCE(p_active_tips, active_tips),
         active_dust=p_active_dust, 
         active_uv=p_active_uv, 
         active_dry=p_active_dry, 
         updated_at=SYSDATE(), 
         approved=p_approved, 
         BillingToken=p_billingtoken, 
         Billingtime=p_billingtime, 
         dailyforecast = COALESCE(p_dailyforecast, dailyforecast),
         ios = p_ios
         where gcm_regid=p_regid;
           
Else 
    if (SUBSTR(p_regid, 1, 3) = 'APA') then
    set v_fcm = 0;
end if;


INSERT INTO `fcm_users` (name, email, gcm_regid, created_at, lang, active, active_rain_etc, active_tips, active_dust, active_uv, active_dry, fcm, ios) VALUES(p_name, p_email, p_regid, SYSDATE(), COALESCE(p_lang, 1), p_active, p_active_rain_etc, p_active_tips, p_active_dust, p_active_uv, p_active_dry, v_fcm, p_ios);

end if;
if (p_email is NOT NULL
        AND p_email <> '') then
    
    select count(*)  into exist from  `fcm_users` where email=p_email;
    
    if (exist > 1) then
       SELECT min(id) into idToRemove FROM fcm_users 
       where email = p_email GROUP BY email;
       
       UPDATE `fcm_users` t, 
       (SELECT approved, BillingToken, Billingtime, DailyForecast
                        FROM `fcm_users`
                       WHERE id=idToRemove) t1
	   SET t.approved = t1.approved,
		t.BillingToken = t1.BillingToken,
		t.Billingtime = t1.Billingtime,
		t.DailyForecast = t1.DailyForecast

	 WHERE gcm_regid=p_regid;
     
     delete from `fcm_users` where id=idToRemove;          
    end if;
end if;

if (p_oldregid <> '') then
UPDATE 
`fcm_users` t, 
(SELECT * FROM `fcm_users` WHERE gcm_regid =p_oldregid) t1 
SET 
t.name = t1.name, 
t.email = t1.email, 
t.lang = t1.lang, 
t.active = t1.active, 
t.active_rain_etc = t1.active_rain_etc, 
t.active_tips = t1.active_tips, 
t.active_dust = t1.active_dust, 
t.active_uv = t1.active_uv, 
t.active_dry = t1.active_dry, 
t.FCM = t1.FCM, 
t.Approved = t1.Approved, 
t.DailyForecast = t1.DailyForecast, 
t.BillingToken = t1.BillingToken,
t.BillingTime = t1.BillingTime 
WHERE t.gcm_regid=p_regid;
end if;


if (p_email is null or p_email = '')  then
LEAVE SaveGCMUser;
end if;

select count(*) into exist from Subscriptions where email=p_email;

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