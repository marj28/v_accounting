
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `chartofaccounts`;
CREATE TABLE `chartofaccounts` (
  `id` int(11) NOT NULL,
  `accountNumber` varchar(11) NOT NULL,
  `accountName` varchar(50) NOT NULL,
  `accountType` varchar(50) NOT NULL,
  `accountDescription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `chartofaccounts` (`id`, `accountNumber`, `accountName`, `accountType`, `accountDescription`) VALUES
(2, '100', 'Cash', 'Assets', 'Just a cash'),
(16, '110', 'Prepaid Expenses', 'Assets', 'The name says it all'),
(17, '120', 'Inventory', 'Assets', 'The name says it all'),
(18, '130', 'Supplies', 'Assets', 'The name says it all'),
(19, '200', 'Accounts Payable', 'liabilities', 'The name says it all'),
(20, '210', 'Notes Payable', 'liabilities', 'the name says it all'),
(21, '300', 'Income', 'Revenue', 'The name says it all'),
(22, '400', 'Cost of Goods Sold', 'Expenses', 'The name says it all'),
(23, '410', 'Supplies Expense', 'Expenses', 'The name says it all'),
(24, '420', 'Utilities Expense', 'Expenses', 'The name says it all'),
(25, '500', 'Capital', 'Owners Equity', 'The name says it all'),
(27, '140', 'Equipment', 'Assets', 'The name says it all');



DROP TABLE IF EXISTS `companyinfo`;
CREATE TABLE `companyinfo` (
  `id` int(11) NOT NULL,
  `companyName` varchar(50) NOT NULL,
  `companyPhone` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `transaction_date` date NOT NULL,
  `id` int(11) NOT NULL,
  `account_number` int(11) NOT NULL,
  `debits` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `journal` (`transaction_date`, `id`, `account_number`, `debits`, `credits`, `description`) VALUES
('2014-09-01', 3, 100, 500000, 0, 0),
('2014-09-01', 4, 500, 0, 500000, 0),
('2014-09-01', 5, 140, 300000, 0, 0),
('2014-09-01', 6, 100, 0, 300000, 0),
('2014-09-02', 7, 100, 200000, 0, 0),
('2014-09-02', 8, 210, 0, 200000, 0),
('2014-09-04', 9, 110, 18000, 0, 0),
('2014-09-04', 10, 100, 0, 18000, 0),
('2014-09-06', 11, 110, 50000, 0, 0),
('2014-09-06', 12, 300, 0, 50000, 0);


ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `chartofaccounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accountNumber` (`accountNumber`,`accountName`);


ALTER TABLE `companyinfo`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `chartofaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;


ALTER TABLE `companyinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;
