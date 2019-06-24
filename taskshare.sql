-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 27, 2019 lúc 04:18 PM
-- Phiên bản máy phục vụ: 10.1.26-MariaDB
-- Phiên bản PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `taskshare`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `project_id` bigint(20) NOT NULL,
  `project_manager_id` bigint(20) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_detail` text NOT NULL,
  `project_start_day` date NOT NULL,
  `project_end_day` date NOT NULL,
  `project_process` tinyint(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`project_id`, `project_manager_id`, `project_name`, `project_detail`, `project_start_day`, `project_end_day`, `project_process`) VALUES
(1, 1, 'Đồ án môn học 2', 'blah blah2', '2019-05-19', '2019-05-31', 0),
(2, 1, 'Dự án khởi nghiệp', 'iououow', '2019-05-20', '2019-05-31', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects_has_users`
--

CREATE TABLE `projects_has_users` (
  `pxu_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `projects_has_users`
--

INSERT INTO `projects_has_users` (`pxu_id`, `project_id`, `user_id`, `role`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(12, 1, 2, 0),
(13, 1, 3, 0),
(14, 1, 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sub_tasks`
--

CREATE TABLE `sub_tasks` (
  `task_id` bigint(20) NOT NULL,
  `stask_name` varchar(45) NOT NULL,
  `stask_state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `task_id` bigint(20) NOT NULL,
  `pxu_id` bigint(20) NOT NULL,
  `task_name` text,
  `process` tinyint(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_fullname` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_birth` date NOT NULL DEFAULT '1990-01-01',
  `user_gender` tinyint(1) NOT NULL DEFAULT '0',
  `user_img` varchar(255) DEFAULT NULL,
  `remember_token` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_fullname`, `user_email`, `user_birth`, `user_gender`, `user_img`, `remember_token`) VALUES
(1, 'haotrg035', '$2y$10$IutII/gnPwXdyXTlufXTdu7Rkrro9MDw/V9lHk3lmcnFX.CMkcto2', 'Truong Nhut Hao', 'haotrg035@gmail.com', '1990-01-01', 0, NULL, NULL),
(2, 'nguyenvana', '$2y$10$6C5/AUqgLBbpfN30X7cfQusgMh.JD4aLLCVk/6y2/hdG7Rh1O6k9.', 'Nguyễn Văn A', 'ngva@gmail.com', '1990-01-01', 0, NULL, NULL),
(3, 'haotrg034', '$2y$10$ABFQPVMRze3iZykpLJ5tGOD6G5RUdYTH8HLgSP1lFZTKIpdob9Kia', 'Truong Nhut Hao', 'haotrg034@gmail.com', '1990-01-01', 0, NULL, NULL),
(4, 'haotrg032', '$2y$10$bN5R4qbxUBB10vzEb8IJhuEJSZCgMdRDSzMbSfmXNm4UHxt.hqvau', 'Truong Nhut Hao', 'haotrg032@gmail.com', '1990-01-01', 0, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Chỉ mục cho bảng `projects_has_users`
--
ALTER TABLE `projects_has_users`
  ADD PRIMARY KEY (`pxu_id`),
  ADD KEY `fk_projects_has_users_projects1` (`project_id`),
  ADD KEY `fk_projects_has_users_users1` (`user_id`);

--
-- Chỉ mục cho bảng `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `fk_tasks_projects_has_users1` (`pxu_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `projects_has_users`
--
ALTER TABLE `projects_has_users`
  MODIFY `pxu_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `projects_has_users`
--
ALTER TABLE `projects_has_users`
  ADD CONSTRAINT `fk_projects_has_users_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projects_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD CONSTRAINT `fk_sub_tasks_tasks1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_projects_has_users1` FOREIGN KEY (`pxu_id`) REFERENCES `projects_has_users` (`pxu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
