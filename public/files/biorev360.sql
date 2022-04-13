SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_role_id` int(10) DEFAULT NULL,
  `manager_ids` text,
  `community_ids` text,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `reset_password` text,
  `email_verified_at` varchar(250) DEFAULT NULL,
  `remember_token` text,
  `vcode` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `status_id` int(5) DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `admins` (`id`, `admin_role_id`, `manager_ids`, `community_ids`,
`username`, `email`, `password`, `mobile`, `name`, `reset_password`,
`email_verified_at`, `remember_token`, `vcode`, `google_id`, `fb_id`,
`status_id`, `created_at`, `updated_at`) VALUES(1, 1, NULL,
NULL, 'admin', 'ankit@biorev.us', '$2y$10$Nk45nutQqEhIkHMEL.0.NerHK16h35e5wD60YLVRCwN9dUypm6uZ2',
'+1 852 741 9944', 'Ankit Kumar', NULL, NULL, NULL, '8994331', NULL, NULL,
2, '2020-01-13 06:20:46', '2020-08-08 13:06:07');


CREATE TABLE `admin_roles` (
  `id` int(10) NOT NULL,
  `role` varchar(150) NOT NULL,
  `status_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `admin_roles` (`id`, `role`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 2, '2020-01-24 02:45:00', '2020-01-24 02:45:00'),
(2, 'Customer', 2, '2020-01-24 02:45:00', '2020-01-24 02:45:00');


CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `home_id` int(10) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '2',
  `imported_on` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `floors` (`id`, `home_id`, `title`, `image`, `status_id`, `imported_on`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'First', '1640089576.png', 2, NULL, '2021-12-17 11:47:28', '2021-12-21 12:26:16', NULL);


CREATE TABLE `homes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specifications` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,0) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `area` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bedroom` tinyint(4) NOT NULL,
  `bathroom` float NOT NULL,
  `garage` tinyint(4) NOT NULL,
  `floor` tinyint(4) DEFAULT NULL,
  `floor_plan` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ext_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` tinyint(4) NOT NULL,
  `imported_on` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `homes` (`id`, `parent_id`, `title`, `slug`, `specifications`, `price`, `img`, `gallery`, `area`, `bedroom`, `bathroom`, `garage`, `floor`, `floor_plan`, `ext_link`, `home_type`, `status_id`, `imported_on`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'Barn', 'barn', 'Barn', '0', '1639741219.png', NULL, '2280', 3, 3, 2, NULL, NULL, NULL, NULL, 2, NULL, '2021-12-17 11:40:19', '2021-12-17 11:40:19', NULL);


CREATE TABLE `nav_segments` (
  `id` int(11) NOT NULL,
  `virtual_tour_segment_id` int(11) NOT NULL,
  `navigation_floor` int(10) DEFAULT NULL,
  `navigate_to` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'pano',
  `title` varchar(255) NOT NULL,
  `x` varchar(255) NOT NULL,
  `y` varchar(255) NOT NULL,
  `z` varchar(255) NOT NULL,
  `level` int(4) NOT NULL DEFAULT '200',
  `zoom_level` int(4) NOT NULL DEFAULT '120',
  `rotation` int(4) NOT NULL DEFAULT '120',
  `thumb_nail` varchar(255) NOT NULL,
  `marker_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `settings` (
  `id` int(20) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `value` text,
  `status` tinyint(4) DEFAULT '1' COMMENT '0:Inactive,1:Active	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`id`, `type`, `name`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'file', 'logo', '1640612187.png', 1, '2020-01-23 15:15:00', '2021-12-27 13:36:27'),
(2, 'file', 'site_favicon', '1640612532.png', 1, '2020-01-13 00:00:00', '2021-12-27 13:42:12'),
(3, 'text', 'site_name', 'Biorev360', 1, '2020-01-23 15:15:00', '2022-01-13 06:15:54'),
(4, 'text', 'site_title', 'Biorev360 Tour', 1, '2020-01-23 15:15:00', '2022-01-13 06:15:54'),
(5, 'email', 'email', 'info@biorev.us', 1, '2020-01-23 15:15:00', '2022-01-13 06:15:54'),
(7, 'text', 'designed_by_company_name', 'Designed By Biorev360', 1, '2021-01-28 16:13:21', '2022-01-13 06:15:54'),
(8, 'textarea', 'description', 'Biorev360, a Virtual Reality company, that is part of Biorev Group of Companies has designed this VR for Texas Legend Construction.', 1, '2021-01-28 16:13:21', '2022-01-13 06:15:54'),
(9, 'textarea', 'disclaimer', 'All images are artist’s renderings, conceptual only, and are based on current development plans which are subject to change without notice. All artwork represented here are the sole property of Biorev360. Any reproduction of them or any other use without the written permission of Biorev360 is strictly prohibited. Prices, plans, dimensions, features, specifications, materials, and availability of homes or communities are subject to change without notice or obligation. Illustrations are artist\'s depictions only and may differ from completed improvements.', 1, '2021-01-28 16:13:21', '2022-01-13 06:15:54');

CREATE TABLE `statuses` (
  `id` int(10) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `colorcode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `statuses` (`id`, `status`, `label`, `colorcode`) VALUES
(1, 'Pending', 'Pending', '#0000ff'),
(2, 'Active', 'Active', '#00ff00'),
(3, 'Trash', 'Trash', '#ff0000');


CREATE TABLE `virtual_tour` (
  `id` int(11) NOT NULL,
  `home_id` int(11) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `default_pano` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `virtual_tour_segments` (
  `id` int(11) NOT NULL,
  `virtual_tour_id` int(11) NOT NULL,
  `is_default` int(1) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `hotspot_top` varchar(255) DEFAULT NULL,
  `hotspot_left` varchar(255) DEFAULT NULL,
  `x` varchar(255) NOT NULL DEFAULT '0',
  `y` varchar(255) NOT NULL DEFAULT '0',
  `z` varchar(255) NOT NULL DEFAULT '100',
  `level` int(4) NOT NULL DEFAULT '200',
  `zoom_level` int(4) NOT NULL DEFAULT '120',
  `rotation` int(4) NOT NULL DEFAULT '120',
  `image` varchar(255) NOT NULL,
  `marker_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wizards` (
  `id` int(10) NOT NULL,
  `step` tinyint(1) DEFAULT '0',
  `home_id` int(10) DEFAULT NULL,
  `floor_id` text,
  `virtual_tour_id` text,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);


ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homes_slug_index` (`slug`(191));


ALTER TABLE `nav_segments`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `virtual_tour`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `virtual_tour_segments`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `wizards`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `admin_roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `homes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `nav_segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `settings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `statuses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `virtual_tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `virtual_tour_segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `wizards`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;
