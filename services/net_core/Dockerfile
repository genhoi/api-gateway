FROM microsoft/dotnet

ENV VOLUME_DIR /app
ENV VOLUME_USER app
ENV VOLUME_USER_ID 1001

RUN useradd -ms /bin/bash -u ${VOLUME_USER_ID} -U ${VOLUME_USER}
RUN apt-get update && \
    apt-get install -y openssh-server openssl \
                       nginx \
                       python-setuptools && easy_install supervisor
# supervisor
ADD build/supervisor /etc/supervisor
ADD build/nginx /etc/nginx

ADD src/ ${VOLUME_DIR}/
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /var/log/nginx && \
    mkdir -p /var/run/sshd && \

    chown -R ${VOLUME_USER}:${VOLUME_USER} ${VOLUME_DIR} && \
    chown -R ${VOLUME_USER}:${VOLUME_USER} /var/log/nginx

RUN cd ${VOLUME_DIR} && \
    dotnet restore

# SSH config
RUN echo 'root:123' | chpasswd && \
    mkdir /root/.ssh && \
    sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config && \
    echo "AllowUsers root" >> /etc/ssh/sshd_config && \
    sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd && \
    echo "export VISIBLE=now" >> /etc/profile

WORKDIR ${VOLUME_DIR}

ENTRYPOINT ["/usr/local/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]