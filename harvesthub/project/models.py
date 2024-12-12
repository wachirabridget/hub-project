from django.db import models

# Create your models here.

class Crop(models.Model):
    crop_name = models.CharField(max_length=255)
    location = models.CharField(max_length=255)
    price_usd = models.DecimalField(max_digits=10, decimal_places=2)

    def __str__(self):
         return f"{self.crop_name} - {self.location}"
    

class Contact(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()
    subject = models.CharField(max_length=200)
    message = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)

    def _str_(self):
        return f"{self.name} - {self.subject}"
