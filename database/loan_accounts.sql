

CREATE TABLE `loan_accounts` (
  `loan_account_id` decimal(2,0) NOT NULL,
  `account_name` varchar(75) NOT NULL,
  `account_no` varchar(75) DEFAULT NULL,
  `account_type` decimal(1,0) NOT NULL,
  `bank_name` varchar(75) DEFAULT NULL,
  `project_id` decimal(6,0) DEFAULT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `current_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` decimal(1,0) NOT NULL DEFAULT 1
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `loan_accounts` (`loan_account_id`, `account_name`, `account_no`, `account_type`, `bank_name`, `status`) VALUES
(11, 'Cash', '', 1, NULL, 1),
(12, 'Rocket', '01707832654', 2, NULL, 1),
(13, 'Bkash', '01521313200', 2, 'Bkash', 1),
(14, 'Nagad', '01970717892', 3, 'Nagad', 1),
(15, 'Islami Bank', '20502676552207816', 4, 'Islami Bank', 1);

--
-- Triggers `loan_accounts`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_loan_account_id` BEFORE INSERT ON `loan_accounts` FOR EACH ROW BEGIN
DECLARE max_id 	  DECIMAL(2);
SELECT MAX(loan_account_id) INTO max_id FROM loan_accounts;
 IF max_id IS NOT NULL THEN
  SET NEW.loan_account_id = max_id+1;
 ELSE
 SET NEW.loan_account_id = 11;
 END IF;
 END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `loan_accounts`
  ADD PRIMARY KEY (`loan_account_id`);
COMMIT;
