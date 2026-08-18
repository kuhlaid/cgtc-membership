<template OverwriteFlag="true" DocrootFlag="false" DirectorySuffix="" TargetDirectory="<%= __DATAGEN_CLASSES__ %>" TargetFileName="QQN.class.php"/>
<?php
	class QQN {
<% foreach ($objTableArray as $objTable) { %>
		static public function <%= $objTable->ClassName %>() {
			return new QQNode<%= $objTable->ClassName %>('<%= $objTable->Name %>', null);
		}
<% } %>
	}
?>