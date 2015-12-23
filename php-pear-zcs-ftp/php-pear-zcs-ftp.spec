%define peardir %(pear config-get php_dir 2> /dev/null || echo %{_datadir}/pear)
%define pear_name zcs-ftp

Name:           php-pear-%{pear_name}
Version:        0.0.1
Release:        1
Summary:        Class that provides ftp

Group:          Development/Libraries
License:        PHP
URL:            http://framework.zend.com
Source0:        http://pear.php.net/get/php-pear-%{pear_name}.tgz

BuildRoot:      %{_tmppath}/%{name}-%{version}-%{release}-root-%(%{__id_u} -n)

BuildArch:      noarch
BuildRequires:  php-pear >= 1:1.4.9-1.2
Provides:	    php-pear(%{pear_name}) = %{version}

%description
%{name}

%prep
%setup -c %{Source0}

%build

%install
rm -rf %{buildroot}
%{__mkdir_p} %{buildroot}%{peardir}
cp -r * %{buildroot}%{peardir}

%clean
rm -rf %{buildroot}

%files
%defattr(-,root,root)
%{peardir}/*

%changelog
* Wed Dec 23 2015 zhangchunsheng<zhangchunsheng423@gmail.com> 0.0.1-1
- init
