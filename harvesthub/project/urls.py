from django.contrib import admin
from django.urls import path
from . import views
# from .views import contact_api

urlpatterns = [
    path('', views.harvesthub, name='harvesthub'),
    path('api/crop-price/', views.get_crop_price, name='get_crop_price'),
    path('contact/',views.contact, name='contact'),
]
