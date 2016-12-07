FROM php:7.0

ENV VOLUME_DIR /app
ENV VOLUME_USER app
ENV VOLUME_USER_ID 1001

RUN useradd -ms /bin/bash -u ${VOLUME_USER_ID} -U ${VOLUME_USER}

#Add composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y openssh-server openssl libevent-dev libssl-dev zlib1g-dev \
                       python-setuptools && easy_install supervisor

# supervisor
ADD build/supervisor /etc/supervisor
# php
RUN docker-php-ext-install mbstring opcache sockets zip
COPY build/php/php.ini /usr/local/etc/php/php.ini

RUN pecl install event
RUN docker-php-ext-enable event

ADD src/ ${VOLUME_DIR}/
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /var/run/sshd && \

    chown -R ${VOLUME_USER}:${VOLUME_USER} ${VOLUME_DIR}

# SSH config
RUN echo 'root:123' | chpasswd && \
    mkdir /root/.ssh && \
    sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config && \
    echo "AllowUsers root" >> /etc/ssh/sshd_config && \
    sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd && \
    echo "export VISIBLE=now" >> /etc/profile

RUN cd ${VOLUME_DIR} && \
    su ${VOLUME_USER} -c 'composer install --no-interaction --optimize-autoloader --no-dev'

WORKDIR ${VOLUME_DIR}
ENTRYPOINT ["/usr/local/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
