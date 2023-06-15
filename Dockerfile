FROM php:zts-buster

RUN pecl install parallel && \
	docker-php-ext-enable parallel && \
	EXTENSION_DIR=`php-config --extension-dir 2>/dev/null` && \
	echo "=====================================================================" && \
	echo "Finished building. SHA256:" && \
	sha256sum "$EXTENSION_DIR/parallel.so" | sed "s/  /\n/" && \
	echo "====================================================================="

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

RUN curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 > ./cc-test-reporter && \
    chmod +x ./cc-test-reporter && \
    ./cc-test-reporter before-build

RUN composer run test


CMD [ "sleep", "36000" ]