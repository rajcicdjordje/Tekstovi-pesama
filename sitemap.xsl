<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<head>
<style type="text/css">
table{
border:3px solid red;
margin-top:20px;
margin-left:200px;
margin-right:200px;

}
body{
background:#8D8D8D;
}
th{
background:yellow;
}
tr:nth-child(even) {background: #CCC}
tr:nth-child(odd) {background: #FFF}
h1{
margin-left:200px;
margin-top:40px;
color:#2621DE;
font-size:65px;
}
</style>
</head>
<body>
<h1><i>Sitemap</i></h1>
<table>
	<tr>
		<th>Loc</th>
		<th>Lastmod</th>
		<th>Changefreq</th>
		<th>Priority</th>
	</tr>
	<xsl:for-each select="urlset/url">
	<tr>
		<td>
			<xsl:variable name="itemURL">
				<xsl:value-of select="loc"/>
			</xsl:variable>
			<a href="{$itemURL}">
				<xsl:value-of select="loc"/>
			</a>
		</td>
		<td><xsl:value-of select="lastmod"/></td>
		<td><xsl:value-of select="changefreq"/></td>
		<td><xsl:value-of select="priority"/></td>
	</tr>
	</xsl:for-each>
</table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>