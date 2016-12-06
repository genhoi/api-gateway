FROM openresty/openresty:latest-xenial

ENV VOLUME_DIR /app

RUN apt-get update && \
    apt-get install -y openssh-server openssl libreadline-dev \
                       libncurses5-dev libpcre3-dev libssl-dev \
                       perl make curl luarocks \
                       python-setuptools && easy_install supervisor && \
    mkdir -p /var/log/supervisor && \
    mkdir -p /var/run/sshd

ADD build/supervisor /etc/supervisor
# SSH config
RUN echo 'root:123' | chpasswd && \
    mkdir /root/.ssh && \
    sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config && \
    echo "AllowUsers root" >> /etc/ssh/sshd_config && \
    sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd && \
    echo "export VISIBLE=now" >> /etc/profile

RUN ln -s /usr/local/openresty/bin/opm /usr/bin/opm

ADD src/ ${VOLUME_DIR}/
RUN mkdir -p ${VOLUME_DIR}/logs

WORKDIR ${VOLUME_DIR}
ENTRYPOINT ["/usr/local/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]