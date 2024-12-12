from django.shortcuts import render
from django.http import JsonResponse
from .models import Crop
from django.views.decorators.csrf import csrf_protect
from django.views.decorators.http import require_http_methods
import sqlite3
from .forms import ContactForm

# Create your views here.
def harvesthub(request):
    return render(request, 'harvesthub.html')


def get_crop_price(request):
    crop_name = request.GET.get('crop')
    location = request.GET.get('location')

    try:
        crop = Crop.objects.get(crop_name=crop_name, location=location)
        return JsonResponse({'price': crop.price_usd})
    except Crop.DoesNotExist:
        return JsonResponse({'error': 'Crop not found'}, status=404)
    # if (!crop || !location):
    #     resultDiv.textContent = 'Please provide both crop and location.'
    #     return
    
def contact(request):
    if request.method == 'POST':
        form = ContactForm(request.POST)
        if form.is_valid():
            form.save()  
            return render(request, 'harvesthub.html', {'form': form})  
    else:
        form = ContactForm()

    return render(request, 'harvesthub.html', {'form': form})