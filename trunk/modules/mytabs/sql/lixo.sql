INSERT INTO `mytabs_page` (`pageid`, `pagetitle`) VALUES
(1,'page1'),
(2,'page2');

INSERT INTO `mytabs_tab` (`tabid`, `tabpageid`, `tabtitle`, `taborder`, `tabgroups`) VALUES
(1, 1, 'page1-tab1', 0, ''),
(2, 1, 'page1-tab2', 0, ''),
(3, 1, 'page1-tab3', 0, ''),
(4, 2, 'page2-tab1', 0, ''),
(5, 2, 'page2-tab2', 0, ''),
(6, 2, 'page2-tab3', 0, '');
