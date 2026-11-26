-- 01_init.sql runs automatically on first boot of lpd-db (empty data dir).
-- Create the auxiliary databases the legacy app expects, plus matching users.
-- Data SQL dumps are imported separately by scripts/import-dumps.sh.

CREATE DATABASE IF NOT EXISTS lpdbalii_siupkonline_baru CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siupkonl_payment CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS siupkonl_new CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS android CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- upkv2new hardcodes these legacy accounts; recreate them so code runs untouched.
CREATE USER IF NOT EXISTS 'siupk_global'@'%' IDENTIFIED BY 'siupk_global';
GRANT ALL PRIVILEGES ON lpdbalii_siupkonline_baru.* TO 'siupk_global'@'%';
GRANT ALL PRIVILEGES ON lpdbalii_demo.* TO 'siupk_global'@'%';
GRANT ALL PRIVILEGES ON siupkonl_payment.* TO 'siupk_global'@'%';
GRANT ALL PRIVILEGES ON siupkonl_new.* TO 'siupk_global'@'%';

CREATE USER IF NOT EXISTS 'siupkonl_payment'@'%' IDENTIFIED BY 'tanyamasrafiaja';
GRANT ALL PRIVILEGES ON siupkonl_payment.* TO 'siupkonl_payment'@'%';

CREATE USER IF NOT EXISTS 'siupkonl_new'@'%' IDENTIFIED BY 'upkbaru';
GRANT ALL PRIVILEGES ON siupkonl_new.* TO 'siupkonl_new'@'%';

CREATE USER IF NOT EXISTS 'siur9777_new'@'%' IDENTIFIED BY 'siur9777_new';
GRANT ALL PRIVILEGES ON lpdbalii_siupkonline_baru.* TO 'siur9777_new'@'%';

GRANT ALL PRIVILEGES ON lpdbalii_demo.* TO 'lpdapp'@'%';
GRANT ALL PRIVILEGES ON lpdbalii_siupkonline_baru.* TO 'lpdapp'@'%';
FLUSH PRIVILEGES;
