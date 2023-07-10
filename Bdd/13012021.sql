CREATE TABLE `time_slot_service` (
  `id` int(100) NOT NULL,
  `service` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `weekday` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `time_slot_service`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `time_slot_service`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE `time_schedule_service` (
  `id` int(100) NOT NULL,
  `service` varchar(500) DEFAULT NULL,
  `weekday` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `time_schedule_service`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `time_schedule_service`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `holidays_service` (
  `id` int(100) NOT NULL,
  `service` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `holidays_service`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `holidays_service`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;  