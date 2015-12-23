PLATFORM=$(shell uname -s)
ARCH=$(shell uname -m)
OS_RELEASE=$(shell /bin/grep -o '[0-9.]\+' /etc/issue)
OS_RELEASE_VERSION=$(shell echo ${OS_RELEASE} | awk -F. '{print $$1;}')

YUM_SERVER=dist.luomor.org
YUM_ONLINE_SERVER=dist.luomor.com
YUM_ROOT=/home/www
YUM_PATH=${YUM_ROOT}/yum
YUM_RPM_PATH=${YUM_PATH}/${OS_RELEASE_VERSION}
YUM_USER=luomor

ifeq (${OS_RELEASE_VERSION}, 5)
RPMBUILD_ROOT=/usr/src/redhat
else
RPMBUILD_ROOT=${HOME}/rpmbuild
endif

RPMBUILD=/usr/bin/rpmbuild -D "_topdir ${RPMBUILD_ROOT}"
RPMSRC=/bin/env rpm -D "_topdir ${RPMBUILD_ROOT}"
RPMBUILD_SPEC=${RPMBUILD} -bb
RPMBUILD_TGZ=${RPMBUILD} -tb
RPMBUILD_REBUILD=${RPMBUILD} --rebuild

all: env

env:
	mkdir -p ${RPMBUILD_ROOT}/{BUILD,BUILDROOT,RPMS,SOURCES,SPECS,SRPMS}

sync: sync2yum

syncandbuild: sync2yum buildrepo

sync2yum:
	for i in x86_64 noarch i686 src; \
	do \
		F=`ls 2>/dev/null |grep "$$i.*\.rpm$$"`; \
		if [ x"$$F" != x ]; then \
			if [ x"$$i" = xsrc ]; then \
				tmp_path=SRPMS; \
			else \
				tmp_path=$$i; \
			fi; \
			rpm --addsign *$$i*.rpm; \
			yum dist-push *$$i*.rpm; \
		fi; \
	done

clean:
	rm -rf *.rpm
	rm -rf *.tgz *.tar.gz
	#rm -rf ${RPMBUILD_ROOT}

build-rpm:
	if [ ${BUILD_SOURCE_FILE} ] ; then :; fi

NAME=php-pear-zcs-ftp
VERSION=$(shell awk '/^Version:/ {print $$2; exit;}' ${NAME}.spec)

ifeq (${OS_RELEASE_VERSION}, 5)
RPMBUILD_ROOT=/usr/src/redhat
endif

all:
	cd src ; \
	tar cfz ${RPMBUILD_ROOT}/SOURCES/${NAME}.tgz * ; \
	cd - ; \
	${RPMBUILD_SPEC} *.spec ;
	rm -rf ${RPMBUILD_ROOT}/SOURCES/*.tgz ;
	cp ${RPMBUILD_ROOT}/RPMS/noarch/${NAME}-${VERSION}*rpm  .
	@echo "done"