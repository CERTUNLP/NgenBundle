FROM grafana/grafana:latest
MAINTAINER CERTunlp
WORKDIR "/"
USER root
RUN apk add --update --no-cache bind-tools curl
USER grafana
#ADD files/grafana.ini /etc/grafana/grafana.ini
#ADD files/dashboard /etc/grafana/provisioning/dashboards/
#ADD files/datasources /etc/grafana/provisioning/datasources/
#ADD files/my_entrypoint /usr/local/bin/my_entrypoint
USER root
RUN chown grafana -R /etc/grafana/provisioning
RUN chown grafana -R /etc/grafana/
USER grafana

#ENTRYPOINT ["my_entrypoint"]
