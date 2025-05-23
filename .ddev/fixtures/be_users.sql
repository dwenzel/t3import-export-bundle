# Default admin user (password = AdminPassword!1)
SET @username := 'admin';
SET @password := '$argon2i$v=19$m=65536,t=16,p=1$dnFPM3F2Z2J1S3RFWW96Mw$bwkXqsGRdSu98m6BpFY7kTekyRDbhN0Dsd8Ib4cQGBY';

INSERT INTO be_users (uid, username, password, admin)
VALUES (1, @username, @password, 1)
ON DUPLICATE KEY UPDATE username = @username,
                        password = @password;
