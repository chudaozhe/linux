模块Apache2.4.1的安装必备的三个模块:apr/apr-util/pcre
http://httpd.apache.org/download.cgi
wget http://mirrors.hust.edu.cn/apache/httpd/httpd-2.2.27.tar.gz

--必备3模块 start--
http://mirrors.hust.edu.cn/apache/apr/apr-1.5.1.tar.gz
http://mirrors.hust.edu.cn/apache/apr/apr-util-1.5.3.tar.gz

http://www.pcre.org/
http://sourceforge.net/projects/pcre/files/pcre/8.35/pcre-8.35.zip/download
--apache必备3模块 end--

http://www.apache.org/dyn/closer.cgi
http://mirrors.hust.edu.cn/apache/httpd/
/usr/local/src/httpd-2.2.27/INSTALL


apt-get install bison libxml2 libxml2-dev built-essential gcc openssl libssl-dev mcrypt libmcrypt-dev libgd2-xpm libgd2-xpm-dev libncurses5-dev

cd /opt
mkdir apr apr-util pcre

cd apr-util-1.5.3
./configure --prefix=/opt/apr-util --with-apr=/opt/apr/ 

cd httpd-2.2.27
./configure --prefix=/opt/httpd --enable-so --enable-mods-shared=all \
--enable-deflate --enable-cache --enable-file-cache --enable-mem-cache \
--enable-disk-cache --with-apr=/opt/apr/ \
--with-apr-util=/opt/apr-util/ --enable-rewrite --enable-expires \
--enable-authn-dbm --enable-vhost-alias --with-mpm=worker --with-ssl \
--disable-ipv6 --disable-cgid --disable-cgi –with-pcre=/usr/local/pcre 
pcre :http://www.server110.com/apache/201308/78.html


  For complete installation documentation, see [ht]docs/manual/install.html or
  http://httpd.apache.org/docs/2.2/install.html

     $ ./configure --prefix=PREFIX
     $ make
     $ make install
     $ PREFIX/bin/apachectl start
./configure --help.

root@cw-Aspire-V5-471G:/usr/local/src/httpd-2.2.27# ./configure --help
`configure' configures this package to adapt to many kinds of systems.

Usage: ./configure [OPTION]... [VAR=VALUE]...

To assign environment variables (e.g., CC, CFLAGS...), specify them as
VAR=VALUE.  See below for descriptions of some of the useful variables.

Defaults for the options are specified in brackets.

Configuration:
  -h, --help              display this help and exit
      --help=short        display options specific to this package
      --help=recursive    display the short help of all the included packages
  -V, --version           display version information and exit
  -q, --quiet, --silent   do not print `checking ...' messages
      --cache-file=FILE   cache test results in FILE [disabled]
  -C, --config-cache      alias for `--cache-file=config.cache'
  -n, --no-create         do not create output files
      --srcdir=DIR        find the sources in DIR [configure dir or `..']

Installation directories:
  --prefix=PREFIX         install architecture-independent files in PREFIX
                          [/usr/local/apache2]
  --exec-prefix=EPREFIX   install architecture-dependent files in EPREFIX
                          [PREFIX]

By default, `make install' will install all the files in
`/usr/local/apache2/bin', `/usr/local/apache2/lib' etc.  You can specify
an installation prefix other than `/usr/local/apache2' using `--prefix',
for instance `--prefix=$HOME'.

For better control, use the options below.

Fine tuning of the installation directories:
  --bindir=DIR            user executables [EPREFIX/bin]
  --sbindir=DIR           system admin executables [EPREFIX/sbin]
  --libexecdir=DIR        program executables [EPREFIX/libexec]
  --sysconfdir=DIR        read-only single-machine data [PREFIX/etc]
  --sharedstatedir=DIR    modifiable architecture-independent data [PREFIX/com]
  --localstatedir=DIR     modifiable single-machine data [PREFIX/var]
  --libdir=DIR            object code libraries [EPREFIX/lib]
  --includedir=DIR        C header files [PREFIX/include]
  --oldincludedir=DIR     C header files for non-gcc [/usr/include]
  --datarootdir=DIR       read-only arch.-independent data root [PREFIX/share]
  --datadir=DIR           read-only architecture-independent data [DATAROOTDIR]
  --infodir=DIR           info documentation [DATAROOTDIR/info]
  --localedir=DIR         locale-dependent data [DATAROOTDIR/locale]
  --mandir=DIR            man documentation [DATAROOTDIR/man]
  --docdir=DIR            documentation root [DATAROOTDIR/doc/PACKAGE]
  --htmldir=DIR           html documentation [DOCDIR]
  --dvidir=DIR            dvi documentation [DOCDIR]
  --pdfdir=DIR            pdf documentation [DOCDIR]
  --psdir=DIR             ps documentation [DOCDIR]

System types:
  --build=BUILD     configure for building on BUILD [guessed]
  --host=HOST       cross-compile to build programs to run on HOST [BUILD]
  --target=TARGET   configure for building compilers for TARGET [HOST]

Optional Features:
  --disable-option-checking  ignore unrecognized --enable/--with options
  --disable-FEATURE       do not include FEATURE (same as --enable-FEATURE=no)
  --enable-FEATURE[=ARG]  include FEATURE [ARG=yes]
  --enable-layout=LAYOUT
  --enable-v4-mapped      Allow IPv6 sockets to handle IPv4 connections
  --enable-exception-hook Enable fatal exception hook
  --enable-maintainer-mode
                          Turn on debugging and compile time warnings
  --enable-pie            Build httpd as a Position Independent Executable
  --enable-modules=MODULE-LIST
                          Space-separated list of modules to enable | "all" |
                          "most"
  --enable-mods-shared=MODULE-LIST
                          Space-separated list of shared modules to enable |
                          "all" | "most"
  --disable-authn-file    file-based authentication control
  --enable-authn-dbm      DBM-based authentication control
  --enable-authn-anon     anonymous user authentication control
  --enable-authn-dbd      SQL-based authentication control
  --disable-authn-default authentication backstopper
  --enable-authn-alias    auth provider alias
  --disable-authz-host    host-based authorization control
  --disable-authz-groupfile
                          'require group' authorization control
  --disable-authz-user    'require user' authorization control
  --enable-authz-dbm      DBM-based authorization control
  --enable-authz-owner    'require file-owner' authorization control
  --enable-authnz-ldap    LDAP based authentication
  --disable-authz-default authorization control backstopper
  --disable-auth-basic    basic authentication
  --enable-auth-digest    RFC2617 Digest authentication
  --enable-isapi          isapi extension support
  --enable-file-cache     File cache
  --enable-cache          dynamic file caching
  --enable-disk-cache     disk caching module
  --enable-mem-cache      memory caching module
  --enable-dbd            Apache DBD Framework
  --enable-bucketeer      buckets manipulation filter
  --enable-dumpio         I/O dump filter
  --enable-echo           ECHO server
  --enable-example        example and demo module
  --enable-case-filter    example uppercase conversion filter
  --enable-case-filter-in example uppercase conversion input filter
  --enable-reqtimeout     Limit time waiting for request from client
  --enable-ext-filter     external filter module
  --disable-include       Server Side Includes
  --disable-filter        Smart Filtering
  --enable-substitute     response content rewrite-like filtering
  --disable-charset-lite  character set translation
  --enable-charset-lite   character set translation
  --enable-deflate        Deflate transfer encoding support
  --enable-ldap           LDAP caching and connection pooling services
  --disable-log-config    logging configuration
  --enable-log-forensic   forensic logging
  --enable-logio          input and output logging
  --disable-env           clearing/setting of ENV vars
  --enable-mime-magic     automagically determining MIME type
  --enable-cern-meta      CERN-type meta files
  --enable-expires        Expires header control
  --enable-headers        HTTP header control
  --enable-ident          RFC 1413 identity check
  --enable-usertrack      user-session tracking
  --enable-unique-id      per-request unique ids
  --disable-setenvif      basing ENV vars on headers
  --disable-version       determining httpd version in config files
  --enable-proxy          Apache proxy module
  --enable-proxy-connect  Apache proxy CONNECT module
  --enable-proxy-ftp      Apache proxy FTP module
  --enable-proxy-http     Apache proxy HTTP module
  --enable-proxy-scgi     Apache proxy SCGI module
  --enable-proxy-ajp      Apache proxy AJP module
  --enable-proxy-balancer Apache proxy BALANCER module
  --enable-ssl            SSL/TLS support (mod_ssl)
  --enable-distcache      Select distcache support in mod_ssl
  --enable-optional-hook-export
                          example optional hook exporter
  --enable-optional-hook-import
                          example optional hook importer
  --enable-optional-fn-import
                          example optional function importer
  --enable-optional-fn-export
                          example optional function exporter
  --enable-static-support Build a statically linked version of the support
                          binaries
  --enable-static-htpasswd
                          Build a statically linked version of htpasswd
  --enable-static-htdigest
                          Build a statically linked version of htdigest
  --enable-static-rotatelogs
                          Build a statically linked version of rotatelogs
  --enable-static-logresolve
                          Build a statically linked version of logresolve
  --enable-static-htdbm   Build a statically linked version of htdbm
  --enable-static-ab      Build a statically linked version of ab
  --enable-static-checkgid
                          Build a statically linked version of checkgid
  --enable-static-htcacheclean
                          Build a statically linked version of htcacheclean
  --enable-static-httxt2dbm
                          Build a statically linked version of httxt2dbm
  --enable-http           HTTP protocol handling
  --disable-mime          mapping of file-extension to MIME
  --enable-dav            WebDAV protocol handling
  --disable-status        process/thread monitoring
  --disable-autoindex     directory listing
  --disable-asis          as-is filetypes
  --enable-info           server information
  --enable-suexec         set uid and gid for spawned processes
  --disable-cgid          CGI scripts
  --enable-cgi            CGI scripts
  --disable-cgi           CGI scripts
  --enable-cgid           CGI scripts
  --enable-dav-fs         DAV provider for the filesystem
  --enable-dav-lock       DAV provider for generic locking
  --enable-vhost-alias    mass virtual hosting module
  --disable-negotiation   content negotiation
  --disable-dir           directory request handling
  --enable-imagemap       server-side imagemaps
  --disable-actions       Action triggering on requests
  --enable-speling        correct common URL misspellings
  --disable-userdir       mapping of requests to user-specific directories
  --disable-alias         mapping of requests to different filesystem parts
  --enable-rewrite        rule based URL manipulation
  --enable-so             DSO capability

Optional Packages:
  --with-PACKAGE[=ARG]    use PACKAGE [ARG=yes]
  --without-PACKAGE       do not use PACKAGE (same as --with-PACKAGE=no)
  --with-included-apr     Use bundled copies of APR/APR-Util
  --with-apr=PATH         prefix for installed APR or the full path to
                             apr-config
  --with-apr-util=PATH    prefix for installed APU or the full path to
                             apu-config
  --with-pcre=PATH        Use external PCRE library
  --with-port=PORT        Port on which to listen (default is 80)
  --with-sslport=SSLPORT  Port on which to securelisten (default is 443)
  --with-z=DIR            use a specific zlib library
  --with-sslc=DIR         RSA SSL-C SSL/TLS toolkit
  --with-ssl=DIR          OpenSSL SSL/TLS toolkit
  --with-mpm=MPM          Choose the process model for Apache to use.
                          MPM={beos|event|worker|prefork|mpmt_os2|winnt}
  --with-module=module-type:module-file
                          Enable module-file in the modules/<module-type>
                          directory.
  --with-program-name     alternate executable name
  --with-suexec-bin       Path to suexec binary
  --with-suexec-caller    User allowed to call SuExec
  --with-suexec-userdir   User subdirectory
  --with-suexec-docroot   SuExec root directory
  --with-suexec-uidmin    Minimal allowed UID
  --with-suexec-gidmin    Minimal allowed GID
  --with-suexec-logfile   Set the logfile
  --with-suexec-safepath  Set the safepath
  --with-suexec-umask     umask for suexec'd process

Some influential environment variables:
  CC          C compiler command
  CFLAGS      C compiler flags
  LDFLAGS     linker flags, e.g. -L<lib dir> if you have libraries in a
              nonstandard directory <lib dir>
  LIBS        libraries to pass to the linker, e.g. -l<library>
  CPPFLAGS    (Objective) C/C++ preprocessor flags, e.g. -I<include dir> if
              you have headers in a nonstandard directory <include dir>
  CPP         C preprocessor

Use these variables to override the choices made by `configure' or to help
it to find libraries and programs with nonstandard names/locations.

Report bugs to the package provider.
--------apache end-------




