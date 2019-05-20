-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               Microsoft SQL Server 2017 (RTM-GDR) (KB4293803) - 14.0.2002.14
-- Server OS:                    Windows 10 Home Single Language 10.0 <X64> (Build 17763: )
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for maybank
CREATE DATABASE IF NOT EXISTS "maybank";
USE "maybank";

-- Dumping structure for table maybank.branches
CREATE TABLE IF NOT EXISTS "branches" (
	"id" INT(10,0) NOT NULL,
	"branch_name" NVARCHAR(255) NOT NULL,
	"branch_address" NVARCHAR(255) NULL DEFAULT NULL,
	"status" INT(10,0) NOT NULL,
	"created_at" DATETIME(3) NULL DEFAULT NULL,
	"updated_at" DATETIME(3) NULL DEFAULT NULL,
	"branch_id" NVARCHAR(255) NOT NULL,
	PRIMARY KEY ("id")
);

-- Dumping data for table maybank.branches: -1 rows
/*!40000 ALTER TABLE "branches" DISABLE KEYS */;
REPLACE INTO "branches" ("id", "branch_name", "branch_address", "status", "created_at", "updated_at", "branch_id") VALUES
	(1, 'Cempaka Putih', 'Cempaka Putih', 1, '2018-12-31 07:50:08.217', '2018-12-31 07:50:08.217', 'BRC1'),
	(2, 'Maybank Bekasi', 'Maybank Bekasi', 1, '2018-12-31 07:50:33.310', '2019-01-02 03:22:06.873', 'BRC3');
/*!40000 ALTER TABLE "branches" ENABLE KEYS */;

-- Dumping structure for table maybank.migrations
CREATE TABLE IF NOT EXISTS "migrations" (
	"id" INT(10,0) NOT NULL,
	"migration" NVARCHAR(255) NOT NULL,
	"batch" INT(10,0) NOT NULL,
	PRIMARY KEY ("id")
);

-- Dumping data for table maybank.migrations: -1 rows
/*!40000 ALTER TABLE "migrations" DISABLE KEYS */;
REPLACE INTO "migrations" ("id", "migration", "batch") VALUES
	(9, '2014_10_12_000000_create_users_table', 1),
	(10, '2014_10_12_100000_create_password_resets_table', 1),
	(11, '2018_12_26_133545_create_user_branchs', 1),
	(12, '2018_12_29_072200_create_branches_table', 1),
	(13, '2018_12_29_073200_create_survei_results', 1),
	(14, '2018_12_29_075602_add_branch_id_branches', 1),
	(15, '2018_12_29_103754_add_branch_id_on_user_branchs', 1),
	(16, '2018_12_29_135718_add_level_survei_result', 1),
	(17, '2019_01_02_161304_add_remember_token', 2);
/*!40000 ALTER TABLE "migrations" ENABLE KEYS */;

-- Dumping structure for table maybank.password_resets
CREATE TABLE IF NOT EXISTS "password_resets" (
	"email" NVARCHAR(255) NOT NULL,
	"token" NVARCHAR(255) NOT NULL,
	"created_at" DATETIME(3) NULL DEFAULT NULL
);

-- Dumping data for table maybank.password_resets: -1 rows
/*!40000 ALTER TABLE "password_resets" DISABLE KEYS */;
/*!40000 ALTER TABLE "password_resets" ENABLE KEYS */;

-- Dumping structure for table maybank.survei_results
CREATE TABLE IF NOT EXISTS "survei_results" (
	"id" INT(10,0) NOT NULL,
	"survei_emot" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"branch_id" INT(10,0) NULL DEFAULT NULL,
	"user_id" INT(10,0) NULL DEFAULT NULL,
	"created_at" DATETIME(3) NULL DEFAULT NULL,
	"updated_at" DATETIME(3) NULL DEFAULT NULL,
	"level_1" INT(10,0) NULL DEFAULT NULL,
	"level_2" INT(10,0) NULL DEFAULT NULL,
	"level_3" INT(10,0) NULL DEFAULT NULL,
	PRIMARY KEY ("id")
);

-- Dumping data for table maybank.survei_results: -1 rows
/*!40000 ALTER TABLE "survei_results" DISABLE KEYS */;
REPLACE INTO "survei_results" ("id", "survei_emot", "branch_id", "user_id", "created_at", "updated_at", "level_1", "level_2", "level_3") VALUES
	(11, NULL, 1, 3, '2019-01-02 17:13:54.313', '2019-01-02 17:13:54.313', NULL, NULL, 1);
/*!40000 ALTER TABLE "survei_results" ENABLE KEYS */;

-- Dumping structure for table maybank.users
CREATE TABLE IF NOT EXISTS "users" (
	"id" INT(10,0) NOT NULL,
	"user_id" NVARCHAR(255) NOT NULL,
	"name" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"email" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"username" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"password" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"created_by" INT(10,0) NULL DEFAULT NULL COMMENT '',
	"remember_token" NVARCHAR(100) NULL DEFAULT NULL,
	"created_at" DATETIME(3) NULL DEFAULT NULL,
	"updated_at" DATETIME(3) NULL DEFAULT NULL,
	PRIMARY KEY ("id")
);

-- Dumping data for table maybank.users: -1 rows
/*!40000 ALTER TABLE "users" DISABLE KEYS */;
REPLACE INTO "users" ("id", "user_id", "name", "email", "username", "password", "created_by", "remember_token", "created_at", "updated_at") VALUES
	(6, 'USR1', NULL, NULL, 'riemann', 'password', NULL, 'MwiiYh7jj1La32D5mW6kShf17kYLBYvfh393zUMd90FTtirkW9w4i2hCLWMS', '2019-01-02 03:49:51.643', '2019-01-02 03:49:51.643');
/*!40000 ALTER TABLE "users" ENABLE KEYS */;

-- Dumping structure for table maybank.user_branchs
CREATE TABLE IF NOT EXISTS "user_branchs" (
	"id" INT(10,0) NOT NULL,
	"user_id" NVARCHAR(255) NOT NULL,
	"first_name" NVARCHAR(255) NOT NULL,
	"last_name" NVARCHAR(255) NOT NULL,
	"username" NVARCHAR(255) NOT NULL,
	"password" NVARCHAR(255) NOT NULL,
	"ip_address" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"token" NVARCHAR(255) NULL DEFAULT NULL COMMENT '',
	"created_by" INT(10,0) NOT NULL,
	"created_at" DATETIME(3) NULL DEFAULT NULL,
	"updated_at" DATETIME(3) NULL DEFAULT NULL,
	"branch_id" INT(10,0) NOT NULL,
	"remember_token" NVARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY ("id")
);

-- Dumping data for table maybank.user_branchs: -1 rows
/*!40000 ALTER TABLE "user_branchs" DISABLE KEYS */;
REPLACE INTO "user_branchs" ("id", "user_id", "first_name", "last_name", "username", "password", "ip_address", "token", "created_by", "created_at", "updated_at", "branch_id", "remember_token") VALUES
	(3, 'USR4', 'apsya', 'dira', 'apsyadira', '$2y$10$6HlDJpjh58v2yL1yc5trJelqR9jSjqmFON3tKDt714wSmrI4LQYvm', '0f5384b52edf6d8aa2b282d983a9006f', '2711281803', 6, '2019-01-02 16:13:41.977', '2019-01-02 16:41:57.267', 1, '1NWqUPDLXLnwMGECe52g2Dr0gqk5eDJEz68Eef55jUCfX59LkMzwuj69g6xe');
/*!40000 ALTER TABLE "user_branchs" ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
