
# Diese fünf Definitionen müssen zusammenpassen...
baseurl="http://joomla-updates.fredbaumgarten.de"
baseuser="root"
basehost="fredbaumgarten.de"
basedir="/var/www/joomla-updates"
basescp="${baseuser}@${basehost}:${basedir}"

# automagische Ermittlung der Versionsnummern - Umstieg auf J! 3.0 sollte kein Problem sein...
jvers=$(shell dirname `pwd`|xargs dirname|xargs basename|sed s/oomla_//|sed "s/[\. ]//g;s/com_clm_android/J25/")
jvers2=$(shell dirname `pwd`|xargs dirname|xargs basename|sed s/Joomla_//|sed "s/ //g;s/com_clm_android/2.5/")
comclmandv=$(shell grep "<version>" clm_android.xml 2>/dev/null|cut -f 2 -d '>'|cut -f 1 -d '<'|sed "s/[\. ]/_/g")
comclmandv2=$(shell grep "<version>" clm_android.xml 2>/dev/null|cut -f 2 -d '>'|cut -f 1 -d '<')

joomladist="../../../../joomladist"

all:
	@make --no-print-directory -s clean deploy

zips: comclmandzip

show:
	echo "Joomla: ${jvers}"
	echo "com_clm_android: ${comclmandv}"

updates: ${joomladist}/com_clm_android_upd_${jvers}.xml

${joomladist}/com_clm_android_upd_${jvers}.xml: clm_android.xml
	echo "<updates>" >> $@
	echo " <update>" >> $@
	echo "  <name>com_clm_android</name>" >> $@
	echo "  <description>Android Interface</description>" >> $@
	echo "  <element>com_clm_android</element>" >> $@
	echo "  <type>component</type>" >> $@
	echo "  <version>${comclmandv2}</version>" >> $@
	echo "  <downloads>" >> $@
	echo "    <downloadurl type=\"full\" format=\"zip\">${baseurl}/com_clm_android_${comclmandv}_${jvers}.zip</downloadurl>" >> $@
	echo "  </downloads>" >> $@
	echo "  <tags>" >> $@
	echo "    <tag>stable</tag>" >> $@
	echo "  </tags>" >> $@
	echo "  <maintainer>Fred Baumgarten</maintainer>" >> $@
	echo "  <maintainerurl>http://sv-hennef.de/</maintainerurl>" >> $@
	echo "  <section>Updates</section>" >> $@
	echo "  <targetplatform name=\"joomla\" version=\"${jvers2}\"/>" >> $@
	echo " </update>" >> $@
	echo "</updates>" >> $@
	scp -q $@ ${basescp}

sendFile:
	ok=`ssh root@fredbaumgarten.de ls /var/www/joomla-updates/${FILE} 2>/dev/null`; \
	 if [ -z "$$ok" ]; then \
		echo "kopiere: ${FILE}" ; \
		scp -q ${joomladist}/${FILE} root@fredbaumgarten.de:/var/www/joomla-updates/ ; \
		echo "`date +%Y-%m-%d-%H:%M:%S` ${FILE}" >> ${joomladist}/updated ; \
	 else \
		echo "bereits online: ${FILE}" ; \
	 fi

deploy: zips updates
	FILE=com_clm_android_${comclmandv}_${jvers}.zip make --no-print-directory sendFile

comclmandzip:
	mkdir -p ${joomladist}
	find . -type f -print | grep -v "/.svn" | grep -v Makefile > ../com_clm_android.files
	zip -q ${joomladist}/com_clm_android_${comclmandv}_${jvers}.zip `cat ../com_clm_android.files`
	rm -f ../com_clm_android.files

clean:
	rm -f ${joomladist}/com_clm_android*
