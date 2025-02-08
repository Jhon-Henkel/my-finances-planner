-- Master database inserts
INSERT INTO tenants (tenant_hash, `database`, username, password) VALUES ('370171777f0ef09ea68fd2915adb6703', 'eyJpdiI6InpHSzlYN0R2bHpkV0xjSFN4UjBzb2c9PSIsInZhbHVlIjoiQW0vQUEvU3J3MkxQU3hyYWtXc2xmMWZIVFNmZGQwL1hDUmMwRlRpakFBa3gyWjRSYmFIdGp4cXNGa28yNWxCWCIsIm1hYyI6IjUzNWE4ZjY1ZGNlNzQ1NWFhN2QyNGEwNzYzYWRmZjczYmY1ZGZkOGU1M2JhMWZmNzAxMTkxNGZmZmI3YzY4NzMiLCJ0YWciOiIifQ==', 'eyJpdiI6IkNMRjY2T2RYTXdxbDkzMnhNeEtHUHc9PSIsInZhbHVlIjoiYVFVTFN2Q0U3dEllUmFCdEZGVEdEdz09IiwibWFjIjoiYTcwOWQ1ZGYyNTg5ZWI5MDdmMWMzMGRlNDUwYTgwMTI2M2NmMzE2YWFkYjFiYTgyODMxZTJjYTdkNWU5MmRmOSIsInRhZyI6IiJ9', 'eyJpdiI6InpLaHlrQ296bTVTSDB1NW5nMUxVaVE9PSIsInZhbHVlIjoiLzRSNmdoZ3dWYTBQdXFpdjNvV0wzdz09IiwibWFjIjoiZTc0MzFkZjlkODY4NzlmNTc4ZTU4YmRiMTRjM2Y4MTMxZjM1Y2RkYTQ1OGFhZjQzMDQwZjgyYjUzMTAwOGE4MSIsInRhZyI6IiJ9');
INSERT INTO users (plan_id, tenant_id, name, email, subscription_id, email_verified_at, password, status, wrong_login_attempts, verify_hash, remember_token) VALUES (1, (SELECT id FROM tenants WHERE tenant_hash = '370171777f0ef09ea68fd2915adb6703'), 'Pipeline User', 'pipeline@pipeline.dev', null, null, '$2y$10$ZTeRATLsEudCq8rmuTzyT.zcLLb8bAy1jDTsh79h1wUJFNI08.Q.W', 1, 0, null, null);

-- Create tenant database
CREATE DATABASE IF NOT EXISTS 370171777f0ef09ea68fd2915adb6703;

-- Add permissions DB user
GRANT ALL PRIVILEGES ON 370171777f0ef09ea68fd2915adb6703.* TO 'testing'@'%' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON 370171777f0ef09ea68fd2915adb6703.* TO 'root'@'%' IDENTIFIED BY '123';

-- Tenant database table creates
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.ai_insight (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, type TINYINT NOT NULL, insight TEXT NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP()) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.configurations (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP()) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.credit_card (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, `limit` DECIMAL(60,2) NOT NULL, status TINYINT DEFAULT 1 NOT NULL, due_date INT NOT NULL, closing_day INT NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP()) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.credit_card_movement (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, credit_card_id INT UNSIGNED NOT NULL, description VARCHAR(255) NOT NULL, type INT NOT NULL, amount DECIMAL(60,2) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), CONSTRAINT credit_card_movement_credit_card_id_foreign FOREIGN KEY (credit_card_id) REFERENCES credit_card (id)) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.credit_card_transaction (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, credit_card_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, value DECIMAL(60,2) NOT NULL, installments INT NOT NULL, next_installment VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), CONSTRAINT credit_card_transaction_credit_card_id_foreign FOREIGN key (credit_card_id) REFERENCES credit_card (id)) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.migrations (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL, batch INT NOT NULL) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.wallets (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, type INT NOT NULL, amount DECIMAL(60,2) NOT NULL, hide_value TINYINT DEFAULT 0 NOT NULL, status TINYINT DEFAULT 1 NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP()) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.future_gain (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, wallet_id INT unsigned NOT NULL, description VARCHAR(255) NOT NULL, amount DECIMAL(60,2) NOT NULL, installments INT DEFAULT 0 NOT NULL, forecast TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), CONSTRAINT future_gain_wallet_id_foreign FOREIGN KEY (wallet_id) REFERENCES wallets (id)) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.future_spent (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, wallet_id INT unsigned NOT NULL, description VARCHAR(255) NOT NULL, amount DECIMAL(60,2) NOT NULL, installments INT DEFAULT 0 NOT NULL, forecast TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), bank_slip_code VARCHAR(255) NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), CONSTRAINT future_spent_wallet_id_foreign FOREIGN KEY (wallet_id) REFERENCES wallets (id)) COLLATE=utf8mb4_unicode_ci;
CREATE TABLE 370171777f0ef09ea68fd2915adb6703.movements (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, wallet_id INT unsigned NOT NULL, description VARCHAR(255) NOT NULL, type INT NOT NULL, amount DECIMAL(60,2) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL ON UPDATE CURRENT_TIMESTAMP(), CONSTRAINT movements_wallet_id_foreign FOREIGN KEY (wallet_id) REFERENCES wallets (id)) COLLATE=utf8mb4_unicode_ci;

-- Populate tenant migrations
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_02_25_192122_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_02_25_235201_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_03_02_000610_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_03_20_231328_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_04_17_152533_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_04_19_100450_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_04_22_200923_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_04_25_111300_migration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_08_03_194419_updating_unique_fields', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2023_10_19_223703_credit_card_movement', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_07_30_065117_create_configuration_for_marketplanner_value', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_09_01_105659_create_first_login_configuration', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_11_21_200420_create-ai-insight-table', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_12_07_062147_add_hide_value_column_on_wallet', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_12_08_143336_add_status_column_on_wallets', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2024_12_24_143336_add_status_column_on_credit_card', 1);
INSERT INTO 370171777f0ef09ea68fd2915adb6703.migrations (migration, batch) VALUES ('2025_02_05_201245_added_column_bank_slip_code_on_future_spent', 1);
