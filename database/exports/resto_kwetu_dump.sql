-- Export Resto Kwetu — généré le 2026-03-25T12:06:56+00:00
-- Driver : mysql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_21_142344_create_personal_access_tokens_table', 1),
(5, '2026_03_21_150000_create_categories_table', 1),
(6, '2026_03_21_150001_create_dishes_table', 1),
(7, '2026_03_21_150002_create_dish_media_table', 1),
(8, '2026_03_21_200000_add_is_new_to_dishes_table', 1),
(9, '2026_03_21_210000_rename_dishes_to_plats', 1),
(10, '2026_03_22_100000_create_restaurants_table', 2),
(11, '2026_03_24_120000_add_description_and_image_to_categories_table', 3),
(12, '2026_03_25_100000_add_type_to_categories_table', 4);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-03-23 16:15:25', '$2y$12$v47kjRTpIamMhP7U.z6zPeAwccMQz.XfCu4BPM5KV/i84KnjoLQX.', '0ogAndSFww', '2026-03-23 16:15:25', '2026-03-23 16:15:25');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GJcmqupblc5TXpMRZ2wFVNnIJYdBW7TTzxxmIrUd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'eyJfdG9rZW4iOiJnSXdLMVpOcHlpQ3VWY25mc0FFNTAwSU5SMWpZakoxbFV3S2RqbDZoIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTozMDAwXC9hZG1pbiIsInJvdXRlIjoiZmlsYW1lbnQuYWRtaW4ucGFnZXMuZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZjEyNjRmYzRhNTRkZjRlYjQzZTlkMzI2MmNjMmM5MTc2NTg2MDllODg5MWVjYjRmNzI3YTI3N2FkOGRlYTk3YyIsInRhYmxlcyI6eyJkZGMxZDA4ZWJlZmE2NTIyOTAzYWIxZjM3YzNjYjhhY19jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5vbSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzbHVnIiwibGFiZWwiOiJTbHVnIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNvcnRfb3JkZXIiLCJsYWJlbCI6Ik9yZHJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlzX2FjdGl2ZSIsImxhYmVsIjoiQWN0aXZlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiVXBkYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiNTYzNTcwOGEwMGU1ZjM5NjI3YTM3MmNkZDc2ODlhZmJfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpbWFnZVByaW5jaXBhbGUuZmlsZV9wYXRoIiwibGFiZWwiOiJQaG90byIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjYXRlZ29yaWUubmFtZSIsImxhYmVsIjoiQ2F0XHUwMGU5Z29yaWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibmFtZSIsImxhYmVsIjoiTm9tIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNsdWciLCJsYWJlbCI6IlNsdWciLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicHJpY2UiLCJsYWJlbCI6IlByaXgiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3VycmVuY3lfY29kZSIsImxhYmVsIjoiRGV2aXNlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByb21vX3ByaWNlIiwibGFiZWwiOiJQcm9tbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hdmFpbGFibGUiLCJsYWJlbCI6IkRpc3BvLiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19mZWF0dXJlZCIsImxhYmVsIjoiXHUwMGMwIGxhIHVuZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19uZXciLCJsYWJlbCI6Ik5vdXYuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByZXBhcmF0aW9uX21pbnV0ZXMiLCJsYWJlbCI6IlByXHUwMGU5cC4gKG1pbikiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic2t1IiwibGFiZWwiOiJSXHUwMGU5Zi4iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidHZhX3JhdGUiLCJsYWJlbCI6IlRWQSAlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNvcnRfb3JkZXIiLCJsYWJlbCI6Ik9yZHJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyXHUwMGU5XHUwMGU5IGxlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InVwZGF0ZWRfYXQiLCJsYWJlbCI6Ik1vZGlmaVx1MDBlOSBsZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJkZWxldGVkX2F0IiwibGFiZWwiOiJTdXBwcmltXHUwMGU5IGxlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCIxYmNlNTIzMGI0MWQyNTI2NDU2YzYyYTcxZWM2YTQ0MF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImxvZ29fcGF0aCIsImxhYmVsIjoiTG9nbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOb20iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2l0eSIsImxhYmVsIjoiVmlsbGUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicGhvbmUiLCJsYWJlbCI6IlRcdTAwZTlsXHUwMGU5cGhvbmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZW1haWwiLCJsYWJlbCI6IkUtbWFpbCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjdXJyZW5jeV9jb2RlIiwibGFiZWwiOiJEZXZpc2UiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiRGVybmlcdTAwZThyZSBtaXNlIFx1MDBlMCBqb3VyIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dfX0=', 1774312018),
('KTLgZRQFWJFcjwyWRnr6YOl2QMarUOa0luRc4FEr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'eyJfdG9rZW4iOiJhUmVWZkhiRTZUYXM5WWNHQjRSdDJoZk5rc0dhbWUxNEJsY0JkQ3ExIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTozMDAwXC9hZG1pblwvcGxhdHNcLzEwXC9lZGl0Iiwicm91dGUiOiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMucGxhdHMuZWRpdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX3dlYiI6ImYxMjY0ZmM0YTU0ZGY0ZWI0M2U5ZDMyNjJjYzJjOTE3NjU4NjA5ZTg4OTFlY2I0ZjcyN2EyNzdhZDhkZWE5N2MiLCJ0YWJsZXMiOnsiZGRjMWQwOGViZWZhNjUyMjkwM2FiMWYzN2MzY2I4YWNfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOb20iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic2x1ZyIsImxhYmVsIjoiU2x1ZyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzb3J0X29yZGVyIiwibGFiZWwiOiJPcmRyZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6IkFjdGl2ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InVwZGF0ZWRfYXQiLCJsYWJlbCI6IlVwZGF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sIjU2MzU3MDhhMDBlNWYzOTYyN2EzNzJjZGQ3Njg5YWZiX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaW1hZ2VQcmluY2lwYWxlLmZpbGVfcGF0aCIsImxhYmVsIjoiUGhvdG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2F0ZWdvcmllLm5hbWUiLCJsYWJlbCI6IkNhdFx1MDBlOWdvcmllIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5vbSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzbHVnIiwibGFiZWwiOiJTbHVnIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByaWNlIiwibGFiZWwiOiJQcml4IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImN1cnJlbmN5X2NvZGUiLCJsYWJlbCI6IkRldmlzZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwcm9tb19wcmljZSIsImxhYmVsIjoiUHJvbW8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfYXZhaWxhYmxlIiwibGFiZWwiOiJEaXNwby4iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfZmVhdHVyZWQiLCJsYWJlbCI6Ilx1MDBjMCBsYSB1bmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfbmV3IiwibGFiZWwiOiJOb3V2LiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwcmVwYXJhdGlvbl9taW51dGVzIiwibGFiZWwiOiJQclx1MDBlOXAuIChtaW4pIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNrdSIsImxhYmVsIjoiUlx1MDBlOWYuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InR2YV9yYXRlIiwibGFiZWwiOiJUVkEgJSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzb3J0X29yZGVyIiwibGFiZWwiOiJPcmRyZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDclx1MDBlOVx1MDBlOSBsZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJNb2RpZmlcdTAwZTkgbGUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZGVsZXRlZF9hdCIsImxhYmVsIjoiU3VwcHJpbVx1MDBlOSBsZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiNDRmN2ExMTViOGJmZDYyNDEyNzk5ZWU0YmNiYzg4NzBfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0eXBlIiwibGFiZWwiOiJUeXBlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImZpbGVfcGF0aCIsImxhYmVsIjoiQXBlclx1MDBlN3UgZmljaGllciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6ZmFsc2V9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJmaWxlX3BhdGgiLCJsYWJlbCI6IkNoZW1pbiBmaWNoaWVyIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImV4dGVybmFsX3VybCIsImxhYmVsIjoiVVJMIGV4dGVybmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfcHJpbWFyeSIsImxhYmVsIjoiUHJpbmNpcGFsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNvcnRfb3JkZXIiLCJsYWJlbCI6Ik9yZHJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNhcHRpb24iLCJsYWJlbCI6IkxcdTAwZTlnZW5kZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XX19', 1774284542),
('LD0LxvDSxORPL7tYqoLwTcrFI8wNFovZ8rgWxpGu', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'eyJfdG9rZW4iOiJHMVZtOVB4TmxFTU1JVTJmbjQ3UHZKYWJIaDNmaTBYRkxaR1JZZkI5IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTozMDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImZpbGFtZW50LmFkbWluLmF1dGgubG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1774440402);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('resro-kwetu-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1774440460),
('resro-kwetu-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1774440460;', 1774440460);

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint unsigned NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image_path`, `type`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(26, 'Entrées & partages', 'entrees-partages-0', 'Pour commencer ou partager entre amis.', 'categories/entrees-partages.jpg', 1, 0, 1, '2026-03-25 11:55:18', '2026-03-25 11:55:18'),
(27, 'Grillades & viandes', 'grillades-viandes-1', 'Au feu de bois et marinades maison.', 'categories/grillades-viandes.jpg', 1, 1, 1, '2026-03-25 11:55:22', '2026-03-25 11:55:22'),
(28, 'Poissons & fruits de mer', 'poissons-fruits-de-mer-2', 'Produits frais selon arrivage.', NULL, 1, 2, 1, '2026-03-25 11:55:29', '2026-03-25 11:55:29'),
(29, 'Pizzas & snacking', 'pizzas-snacking-3', 'Pâte fine croustillante.', 'categories/pizzas-snacking.jpg', 1, 3, 1, '2026-03-25 11:55:33', '2026-03-25 11:55:33'),
(30, 'Desserts', 'desserts-4', 'Douceurs du chef.', NULL, 1, 4, 1, '2026-03-25 11:55:37', '2026-03-25 11:55:37'),
(31, 'Cocktails & mocktails', 'cocktails-mocktails-5', 'Bar lounge — avec ou sans alcool.', NULL, 2, 5, 1, '2026-03-25 11:55:42', '2026-03-25 11:55:42'),
(32, 'Bières & pressions', 'bieres-pressions-6', 'Sélection locale et importée.', NULL, 2, 6, 1, '2026-03-25 11:55:50', '2026-03-25 11:55:50'),
(33, 'Vins & bulles', 'vins-bulles-7', 'Verre ou bouteille.', 'categories/vins-bulles.jpg', 2, 7, 1, '2026-03-25 11:55:53', '2026-03-25 11:55:53'),
(34, 'Spiritueux', 'spiritueux-8', 'Servis au comptoir.', 'categories/spiritueux.jpg', 2, 8, 1, '2026-03-25 11:55:58', '2026-03-25 11:55:58'),
(35, 'Jus & softs', 'jus-softs-9', 'Rafraîchissements.', NULL, 2, 9, 1, '2026-03-25 11:56:01', '2026-03-25 11:56:01');

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_secondary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `currency_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Africa/Lubumbashi',
  `opening_hours` json DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `restaurants` (`id`, `name`, `slogan`, `description`, `logo_path`, `cover_path`, `email`, `phone`, `phone_secondary`, `website`, `address`, `city`, `postal_code`, `country`, `latitude`, `longitude`, `currency_code`, `timezone`, `opening_hours`, `social_links`, `created_at`, `updated_at`) VALUES
(2, 'Resto Kwetu', 'Lounge Bar, terrasse-piscine et salon privé', 'Lounge Bar, terrasse-piscine et salon privé. Un cadre unique à Kinshasa pour vos repas, événements et moments de détente.', NULL, NULL, NULL, '+243 892 959 640', NULL, NULL, '88, Avenue Nguma 3, Ngaliema, Macampagne (Ref : en diagonale d\'Allée Verte)', 'Kinshasa', NULL, 'Congo (RDC)', '-4.3217000', '15.2663000', 'USD', 'Africa/Kinshasa', '{"Jeudi": "08:00 – 22:30", "Lundi": "08:00 – 22:30", "Mardi": "08:00 – 22:30", "Samedi": "08:00 – 22:30", "Dimanche": "08:00 – 22:30", "Mercredi": "08:00 – 22:30", "Vendredi": "08:00 – 22:30"}', '{"facebook": "https://facebook.com/restokwetu", "instagram": "https://www.instagram.com/resto.kwetu/"}', '2026-03-25 11:55:14', '2026-03-25 11:55:14');

DROP TABLE IF EXISTS `plats`;
CREATE TABLE `plats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL,
  `currency_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EUR',
  `promo_price` decimal(12,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `preparation_minutes` smallint unsigned DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allergens` json DEFAULT NULL,
  `dietary_tags` json DEFAULT NULL,
  `tva_rate` decimal(5,2) DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dishes_slug_unique` (`slug`),
  UNIQUE KEY `dishes_sku_unique` (`sku`),
  KEY `dishes_category_id_sort_order_index` (`category_id`,`sort_order`),
  KEY `dishes_is_available_is_featured_index` (`is_available`,`is_featured`),
  CONSTRAINT `dishes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `plats` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `currency_code`, `promo_price`, `is_available`, `is_featured`, `is_new`, `preparation_minutes`, `sku`, `allergens`, `dietary_tags`, `tva_rate`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(221, 26, 'Bruschetta tomate & basilic', 'bruschetta-tomate-basilic-26-0', 'Pain grillé, tomates fraîches, basilic, huile d’olive.', '8.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:18', '2026-03-25 11:55:18', NULL),
(222, 26, 'Carpaccio de bœuf', 'carpaccio-de-boeuf-26-1', 'Fines lamelles, roquette, copeaux de parmesan, citron.', '12.00', 'USD', NULL, 1, 1, 0, 20, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:19', '2026-03-25 11:55:19', NULL),
(223, 26, 'Calamars frits', 'calamars-frits-26-2', 'Servis avec sauce ail-persil.', '9.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:20', '2026-03-25 11:55:20', NULL),
(224, 26, 'Salade César au poulet', 'salade-cesar-au-poulet-26-3', 'Laitue romaine, poulet grillé, parmesan, croûtons, sauce maison.', '10.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 3, '2026-03-25 11:55:21', '2026-03-25 11:55:21', NULL),
(225, 27, 'Brochettes de bœuf', 'brochettes-de-boeuf-27-0', 'Marinade maison, légumes de saison.', '16.00', 'USD', NULL, 1, 1, 0, 20, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:22', '2026-03-25 11:55:22', NULL),
(226, 27, 'Côtelettes d’agneau aux herbes', 'cotelettes-dagneau-aux-herbes-27-1', 'Accompagnement au choix du chef.', '22.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:23', '2026-03-25 11:55:23', NULL),
(227, 27, 'Poulet grillé miel-moutarde', 'poulet-grille-miel-moutarde-27-2', 'Cuisse et filet, sauce maison.', '14.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:26', '2026-03-25 11:55:26', NULL),
(228, 27, 'Steak 250 g sauce au poivre', 'steak-250-g-sauce-au-poivre-27-3', 'Pièce du boucher, frites ou purée.', '24.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 3, '2026-03-25 11:55:27', '2026-03-25 11:55:27', NULL),
(229, 28, 'Poisson du jour grillé', 'poisson-du-jour-grille-28-0', 'Légumes vapeur, sauce citron vert.', '18.00', 'USD', NULL, 1, 1, 0, 20, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:29', '2026-03-25 11:55:29', NULL),
(230, 28, 'Crevettes à l’ail', 'crevettes-a-lail-28-1', 'Persil, beurre, pain grillé.', '17.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:30', '2026-03-25 11:55:30', NULL),
(231, 28, 'Pavé de saumon', 'pave-de-saumon-28-2', 'Sauce citron-aneth, riz basmati.', '19.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:31', '2026-03-25 11:55:31', NULL),
(232, 29, 'Pizza Margherita', 'pizza-margherita-29-0', 'Tomate, mozzarella, basilic frais.', '11.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:33', '2026-03-25 11:55:33', NULL),
(233, 29, 'Pizza 4 saisons', 'pizza-4-saisons-29-1', 'Jambon, champignons, artichauts, olives.', '13.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:34', '2026-03-25 11:55:34', NULL),
(234, 29, 'Burger maison', 'burger-maison-29-2', 'Steak haché, cheddar, bacon, frites.', '12.50', 'USD', NULL, 1, 1, 0, 20, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:35', '2026-03-25 11:55:35', NULL),
(235, 30, 'Tiramisu', 'tiramisu-30-0', 'Recette classique, cacao amer.', '6.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:37', '2026-03-25 11:55:37', NULL),
(236, 30, 'Crème brûlée vanille', 'creme-brulee-vanille-30-1', 'Caramel croquant.', '5.50', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:38', '2026-03-25 11:55:38', NULL),
(237, 30, 'Brownie chocolat-noisette', 'brownie-chocolat-noisette-30-2', 'Glace vanille.', '6.00', 'USD', NULL, 1, 0, 0, 20, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:39', '2026-03-25 11:55:39', NULL),
(238, 31, 'Mojito classique', 'mojito-classique-31-0', 'Rhum, menthe, citron vert, sucre de canne.', '7.00', 'USD', NULL, 1, 1, 0, 5, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:42', '2026-03-25 11:55:42', NULL),
(239, 31, 'Caïpirinha', 'caipirinha-31-1', 'Cachaça, citron vert, sucre.', '7.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:43', '2026-03-25 11:55:43', NULL),
(240, 31, 'Virgin mojito', 'virgin-mojito-31-2', 'Sans alcool, tout le frais du mojito.', '5.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:46', '2026-03-25 11:55:46', NULL),
(241, 31, 'Piña colada (sans alcool)', 'pina-colada-sans-alcool-31-3', 'Ananas, coco, glace pilée.', '5.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 3, '2026-03-25 11:55:47', '2026-03-25 11:55:47', NULL),
(242, 32, 'Bière locale — pression 50 cl', 'biere-locale-pression-50-cl-32-0', 'Selon arrivage du jour.', '3.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:50', '2026-03-25 11:55:50', NULL),
(243, 32, 'Bière importée 33 cl', 'biere-importee-33-cl-32-1', 'Large choix au bar.', '4.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:51', '2026-03-25 11:55:51', NULL),
(244, 33, 'Verre de vin rouge', 'verre-de-vin-rouge-33-0', 'Sélection maison.', '5.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:53', '2026-03-25 11:55:53', NULL),
(245, 33, 'Verre de vin blanc', 'verre-de-vin-blanc-33-1', 'Frais et fruité.', '5.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:54', '2026-03-25 11:55:54', NULL),
(246, 33, 'Bouteille — carte du mois', 'bouteille-carte-du-mois-33-2', 'Demandez la sélection au serveur.', '28.00', 'USD', NULL, 1, 1, 0, 5, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:55:55', '2026-03-25 11:55:55', NULL),
(247, 34, 'Rhum vieux — 4 cl', 'rhum-vieux-4-cl-34-0', 'Sélection bar.', '6.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:55:58', '2026-03-25 11:55:58', NULL),
(248, 34, 'Whisky premium — 4 cl', 'whisky-premium-4-cl-34-1', 'Selon disponibilité.', '9.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:55:59', '2026-03-25 11:55:59', NULL),
(249, 35, 'Jus d’orange frais', 'jus-dorange-frais-35-0', 'Pressé du jour.', '3.00', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 0, '2026-03-25 11:56:01', '2026-03-25 11:56:01', NULL),
(250, 35, 'Soda 33 cl', 'soda-33-cl-35-1', 'Coca, Fanta, Sprite…', '2.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 1, '2026-03-25 11:56:02', '2026-03-25 11:56:02', NULL),
(251, 35, 'Eau minérale 50 cl', 'eau-minerale-50-cl-35-2', 'Plate ou gazeuse.', '1.50', 'USD', NULL, 1, 0, 0, 5, NULL, '[]', '[]', NULL, 2, '2026-03-25 11:56:03', '2026-03-25 11:56:03', NULL);

DROP TABLE IF EXISTS `medias_plats`;
CREATE TABLE `medias_plats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plat_id` bigint unsigned NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dish_media_dish_id_type_sort_order_index` (`plat_id`,`type`,`sort_order`),
  CONSTRAINT `medias_plats_plat_id_foreign` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=631 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `medias_plats` (`id`, `plat_id`, `type`, `disk`, `file_path`, `external_url`, `is_primary`, `sort_order`, `caption`, `created_at`, `updated_at`) VALUES
(606, 222, 'photo', 'public', 'medias-plats/kwetu/222.jpg', NULL, 1, 0, 'Carpaccio de bœuf', '2026-03-25 11:55:20', '2026-03-25 11:55:20'),
(607, 223, 'photo', 'public', 'medias-plats/kwetu/223.jpg', NULL, 1, 0, 'Calamars frits', '2026-03-25 11:55:21', '2026-03-25 11:55:21'),
(608, 224, 'photo', 'public', 'medias-plats/kwetu/224.jpg', NULL, 1, 0, 'Salade César au poulet', '2026-03-25 11:55:22', '2026-03-25 11:55:22'),
(609, 225, 'photo', 'public', 'medias-plats/kwetu/225.jpg', NULL, 1, 0, 'Brochettes de bœuf', '2026-03-25 11:55:23', '2026-03-25 11:55:23'),
(610, 226, 'photo', 'public', 'medias-plats/kwetu/226.jpg', NULL, 1, 0, 'Côtelettes d’agneau aux herbes', '2026-03-25 11:55:26', '2026-03-25 11:55:26'),
(611, 227, 'photo', 'public', 'medias-plats/kwetu/227.jpg', NULL, 1, 0, 'Poulet grillé miel-moutarde', '2026-03-25 11:55:27', '2026-03-25 11:55:27'),
(612, 228, 'photo', 'public', 'medias-plats/kwetu/228.jpg', NULL, 1, 0, 'Steak 250 g sauce au poivre', '2026-03-25 11:55:28', '2026-03-25 11:55:28'),
(613, 229, 'photo', 'public', 'medias-plats/kwetu/229.jpg', NULL, 1, 0, 'Poisson du jour grillé', '2026-03-25 11:55:30', '2026-03-25 11:55:30'),
(614, 230, 'photo', 'public', 'medias-plats/kwetu/230.jpg', NULL, 1, 0, 'Crevettes à l’ail', '2026-03-25 11:55:31', '2026-03-25 11:55:31'),
(615, 231, 'photo', 'public', 'medias-plats/kwetu/231.jpg', NULL, 1, 0, 'Pavé de saumon', '2026-03-25 11:55:33', '2026-03-25 11:55:33'),
(616, 232, 'photo', 'public', 'medias-plats/kwetu/232.jpg', NULL, 1, 0, 'Pizza Margherita', '2026-03-25 11:55:34', '2026-03-25 11:55:34'),
(617, 233, 'photo', 'public', 'medias-plats/kwetu/233.jpg', NULL, 1, 0, 'Pizza 4 saisons', '2026-03-25 11:55:35', '2026-03-25 11:55:35'),
(618, 234, 'photo', 'public', 'medias-plats/kwetu/234.jpg', NULL, 1, 0, 'Burger maison', '2026-03-25 11:55:36', '2026-03-25 11:55:36'),
(619, 235, 'photo', 'public', 'medias-plats/kwetu/235.jpg', NULL, 1, 0, 'Tiramisu', '2026-03-25 11:55:38', '2026-03-25 11:55:38'),
(620, 236, 'photo', 'public', 'medias-plats/kwetu/236.jpg', NULL, 1, 0, 'Crème brûlée vanille', '2026-03-25 11:55:39', '2026-03-25 11:55:39'),
(621, 238, 'photo', 'public', 'medias-plats/kwetu/238.jpg', NULL, 1, 0, 'Mojito classique', '2026-03-25 11:55:43', '2026-03-25 11:55:43'),
(622, 239, 'photo', 'public', 'medias-plats/kwetu/239.jpg', NULL, 1, 0, 'Caïpirinha', '2026-03-25 11:55:46', '2026-03-25 11:55:46'),
(623, 241, 'photo', 'public', 'medias-plats/kwetu/241.jpg', NULL, 1, 0, 'Piña colada (sans alcool)', '2026-03-25 11:55:49', '2026-03-25 11:55:49'),
(624, 242, 'photo', 'public', 'medias-plats/kwetu/242.jpg', NULL, 1, 0, 'Bière locale — pression 50 cl', '2026-03-25 11:55:51', '2026-03-25 11:55:51'),
(625, 244, 'photo', 'public', 'medias-plats/kwetu/244.jpg', NULL, 1, 0, 'Verre de vin rouge', '2026-03-25 11:55:54', '2026-03-25 11:55:54'),
(626, 245, 'photo', 'public', 'medias-plats/kwetu/245.jpg', NULL, 1, 0, 'Verre de vin blanc', '2026-03-25 11:55:55', '2026-03-25 11:55:55'),
(627, 248, 'photo', 'public', 'medias-plats/kwetu/248.jpg', NULL, 1, 0, 'Whisky premium — 4 cl', '2026-03-25 11:56:00', '2026-03-25 11:56:00'),
(628, 249, 'photo', 'public', 'medias-plats/kwetu/249.jpg', NULL, 1, 0, 'Jus d’orange frais', '2026-03-25 11:56:02', '2026-03-25 11:56:02'),
(629, 250, 'photo', 'public', 'medias-plats/kwetu/250.jpg', NULL, 1, 0, 'Soda 33 cl', '2026-03-25 11:56:03', '2026-03-25 11:56:03'),
(630, 251, 'photo', 'public', 'medias-plats/kwetu/251.jpg', NULL, 1, 0, 'Eau minérale 50 cl', '2026-03-25 11:56:05', '2026-03-25 11:56:05');

SET FOREIGN_KEY_CHECKS=1;
